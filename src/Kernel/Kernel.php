<?php

namespace BDP\Kernel;

use BDP\Kernel\Components\Configuration\KernelConfiguration;
use BDP\Kernel\Components\Container\ContainerBuilder;
use BDP\Kernel\Components\Environment\DotenvUploader;
use BDP\Kernel\Components\Exception\ExceptionHandler;
use BDP\Kernel\Components\Middlewares\JsonMiddleware;
use BDP\Kernel\Components\Routing\Entrypoint;
use BDP\Kernel\Components\Routing\RoutesApplier;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App;
use Slim\Factory\AppFactory;

final readonly class Kernel
{
    private function __construct(private App $app)
    {
    }

    /** @throws Exception */
    public static function create(): Kernel
    {
        $environment = new DotenvUploader();
        $environment->validate();

        $containerBuilder = new ContainerBuilder();
        $container = $containerBuilder->build();

        $slim = AppFactory::createFromContainer($container);

        $kernel = new self($slim);
        $kernel->configure();

        return $kernel;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function configure(): void
    {
        /** @var KernelConfiguration $configuration */
        $configuration = $this->app->getContainer()->get(KernelConfiguration::class);

        $this->app->addMiddleware(new JsonMiddleware());
        $this->app->addBodyParsingMiddleware();

        $middleware = $this->app->addErrorMiddleware(
            $configuration->errorDetails(),
            $configuration->logErrors(),
            $configuration->logErrorDetails()
        );
        $handler = new ExceptionHandler(
            $this->app->getCallableResolver(),
            $this->app->getResponseFactory()
        );
        $middleware->setDefaultErrorHandler($handler);

        if ($configuration->useSingleEntrypoint()) {
            $this->app->post(
                pattern: $configuration->getEndpoint(),
                callable: $this->app->getContainer()->get(Entrypoint::class)
            );
        } else {
            $routesApplier = new RoutesApplier($this->app);
            $routesApplier->apply();
        }
    }

    public function run(): void
    {
        $this->app->run();
    }
}