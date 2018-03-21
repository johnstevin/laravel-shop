<?php
namespace SimpleShop\Commodity;

<<<<<<< HEAD
use SimpleShop\Commodity\Blade\Detail\Attr;
use SimpleShop\Commodity\Blade\Detail\Content;
use SimpleShop\Commodity\Blade\Detail\Crumb;
use SimpleShop\Commodity\Blade\Detail\Image;
use SimpleShop\Commodity\Blade\Detail\Params;
use SimpleShop\Commodity\Blade\Detail\Recommend;
use SimpleShop\Commodity\Blade\Index\GoodsList;
use SimpleShop\Commodity\Blade\Index\Paginate;
use SimpleShop\Commodity\Blade\Index\Screening;
use SimpleShop\Commodity\Blade\Search\Total;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Foundation\Application as LaravelApplication;
use SimpleShop\Commodity\Blade\TplConfig;
use SimpleShop\Commodity\Search\RepositoryInterface;
use SimpleShop\Commodity\Search\SearchRepository;
use SimpleShop\Commodity\Sku;
use Blade;
=======
use App\Services\Tpl\Commodity\Detail\Attr;
use App\Services\Tpl\Commodity\Detail\Content;
use App\Services\Tpl\Commodity\Detail\Crumb;
use App\Services\Tpl\Commodity\Detail\Image;
use App\Services\Tpl\Commodity\Detail\Params;
use App\Services\Tpl\Commodity\Index\Screening;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Foundation\Application as LaravelApplication;
use SimpleShop\Commodity\Search\RepositoryInterface;
use SimpleShop\Commodity\Search\SearchRepository;
use Illuminate\Support\Facades\Blade;
use SimpleShop\Commodity\Sku;
>>>>>>> 9e286fa16e60cc5662ba14ef655a6b0476978e19

class CommodityServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->setupConfig($this->app);
		$this->setupMigrations($this->app);
        $this->loadViewsFrom(dirname(__FILE__) . '/Views', 'Goods');
        $this->bootProduct();
        $this->bootImage();
        $this->bootParams();
        $this->bootAttr();
        $this->bootContent();
        $this->bootScreening();
<<<<<<< HEAD
        $this->bootGoodsList();
        $this->bootPaginate();
        $this->bootSearchImage();
        $this->bootSearchTotal();
        $this->bootRecommend();
        $this->bladeTplConfig();

	}

	public function bladeTplConfig() {
        Blade::directive('tplConfig', function ($expression) {
            $arr = explode('.', $expression);
            $tpl = $arr[0];
            $key = $arr[1];
            return TplConfig::get($tpl,$key);
        });
    }

=======
	}

>>>>>>> 9e286fa16e60cc5662ba14ef655a6b0476978e19
	/**
	 * 初始化配置
	 *
	 * @param \Illuminate\Contracts\Container\Container $app
	 *
	 * @return void
	 */
	protected function setupConfig(Application $app)
	{
		$source = realpath(__DIR__.'/../config/commodity.php');

		if ($app instanceof LaravelApplication && $app->runningInConsole()) {
			$this->publishes([$source => config_path('commodity.php')]);
		} elseif ($app instanceof LumenApplication) {
			$app->configure('commodity');
		}

		$this->mergeConfigFrom($source, 'commodity');
	}

	/**
	 * 初始化数据库
	 *
	 * @param \Illuminate\Contracts\Container\Container $app
	 *
	 * @return void
	 */
	protected function setupMigrations(Application $app)
	{
		$source = realpath(__DIR__.'/../database/migrations/');

		if ($app instanceof LaravelApplication && $app->runningInConsole()) {
			$this->publishes([$source => database_path('migrations')], 'migrations');
		}
	}

    /**
     *
     */
    public function bootProduct()
    {
        Blade::directive('crumb', function ($expression) {
            return Crumb::html($expression);
        });
	}

<<<<<<< HEAD
    public function bootRecommend()
    {
        Blade::directive('recommend', function ($expression) {
            return Recommend::html($expression);
        });
	}

=======
>>>>>>> 9e286fa16e60cc5662ba14ef655a6b0476978e19
    public function bootImage()
    {
        Blade::directive('image', function ($expression) {
            return Image::html($expression);
        });
	}

<<<<<<< HEAD
    public function bootSearchImage()
    {
        Blade::directive('search_image', function () {
            return \SimpleShop\Commodity\Blade\Search\Image::html();
        });
	}

=======
>>>>>>> 9e286fa16e60cc5662ba14ef655a6b0476978e19
    public function bootParams()
    {
        Blade::directive('params', function ($expression) {
            return Params::html($expression);
        });
    }

    public function bootAttr()
    {
        Blade::directive('attr', function ($expression) {
            return Attr::html($expression);
        });
    }

    public function bootContent()
    {
        Blade::directive('content', function ($expression) {
            return Content::html($expression);
        });
    }

    public function bootScreening()
    {
        Blade::directive('screening', function () {
            return Screening::html();
        });
    }

<<<<<<< HEAD
    public function bootGoodsList()
    {
        Blade::directive('goodsList', function () {
            return GoodsList::html();
        });
    }

    public function bootPaginate()
    {
        Blade::directive('paginate', function () {
            return Paginate::html();
        });
    }

    public function bootSearchTotal()
    {
        Blade::directive('search_total', function () {
            return Total::html();
        });
    }

=======
>>>>>>> 9e286fa16e60cc5662ba14ef655a6b0476978e19
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

        Blade::directive('shoplist', function($expression) {
//            $params = collect(explode(',', $expression))->map(function ($item) {
//                return trim($item);
//            });
//            $params->get(0)；
//            $data = app(\SimpleShop\Commodity\Commodity::class)->search(['not_ids'=>[1]]);
            return
                "<?php foreach (app(\SimpleShop\Commodity\Commodity::class)->search(['not_ids'=>[1]]) as \$key=>\$item) : ?>";

        });
        Blade::directive('endshoplist', function($expression) {
            return "<?php endforeach; ?>";

        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
