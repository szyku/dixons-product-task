<?php declare(strict_types=1);


namespace Dixons\Http;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Loader\YamlFileLoader as RouteYamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as DependencyYamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

final class Kernel extends HttpKernel
{
    private const CONFIG_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'Config';

    /** @var ContainerInterface */
    private $container;

    public function __construct()
    {
        $this->bootstrapServiceContainer();
        $this->init();
    }

    private function loadRoutes(): RouteCollection
    {
        $fileLocator = new FileLocator([self::CONFIG_DIR,]);
        $loader = new RouteYamlFileLoader($fileLocator);
        return $loader->load('routes.yaml');
    }

    private function init(): void
    {
        $routes = $this->loadRoutes();
        $matcher = new UrlMatcher($routes, new RequestContext());

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

        parent::__construct($dispatcher, new ControllerResolver(), new RequestStack(), new ArgumentResolver());
    }

    private function bootstrapServiceContainer(): void
    {
        $this->container = new ContainerBuilder();
        $loader = new DependencyYamlFileLoader($this->container, new FileLocator(self::CONFIG_DIR));

        $loader->load('services.yaml');

        $this->container->getParameterBag()->add([
            'kernel.dir' => __DIR__,
        ]);
    }



    public function run()
    {
        $request = Request::createFromGlobals();
        $response = $this->handle($request);
        $this->terminate($request, $response);
    }
}