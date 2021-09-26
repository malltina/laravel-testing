<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function dd;
use function ucwords;
use function collect;
use function dump;
use Illuminate\Support\Facades\Http;

class Test extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        $result=$response->failed();
//            $response->body();
//        $response->json();
//        $response->object();
//        $response->collect();
//        $response->status();
//        $response->ok();
//        $response->successful();
//        $response->failed();
//        $response->serverError();
//        $response->clientError();
//        $response->header($header);
//        $response->headers();

        dd($result);





//        $collection = collect([1, 2, 3, 4]);
        $total = $collection->reduce(function ($carry, $item) {
            return $carry * $item;
        });
        dd($total);
        $total = $collection->reduce(function ($carry, $item) {
            dump($carry, $item, '-');

            return $carry + $item;
        });
        dd($total);
        $collection = collect([1, 2, 3, 4]);
        dd($collection->pop(), $collection->last());
        $collection = collect(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h']);
        dd($collection->nth(3, 3));
        $collection = collect([1, 1, 2, 2, 3, 4, 2]);
        dd($collection->count());
        $collection = collect([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ]);
        $collapsed = $collection->collapse();
        dd($collapsed->all());
        $collection = collect([
            ['product_id' => 'prod-100', 'name' => 'Desk'],
            ['product_id' => 'prod-200', 'name' => 'Chair'],
        ]);
        dd($collection->map(function ($value, $key) {
            return $value['product_id'];
        })->all(), $collection->pluck('product_id')->all());
        dd('done');
        dd($collection->pluck('product_id')->all());
        $collection = collect(['ali a', 'hasan h', 'mehdi m', 'mehrdad m']);
        $result     = $collection->map(function ($item) {
            return ucwords($item);
        });
        dd($result);
        $collection = collect([1, 2, 3, null, false, '', 0, []]);
        dd($collection->filter());
        $collection = collect([1, 2, 3, 4]);
        $filtered   = $collection->filter(function ($value, $key) {
            return $value > 1;
        });
        dd($filtered);
        $collection = collect([
            'Apple'   => [
                [
                    'name'  => 'iPhone 6S',
                    'brand' => 'Apple',
                ],
            ],
            'Samsung' => [
                [
                    'name'  => 'Galaxy S7',
                    'brand' => 'Samsung',
                ],
            ],
        ]);
        $products   = $collection->flatten(2);
        dd($products);
        $collection = collect([
            'name'      => 'taylor',
            'languages' => [
                'php', 'javascript',
            ],
        ]);
        dd($collection->flatten());
        $collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => 100],
            ['product' => 'Bookcase', 'price' => 150],
            ['product' => 'Door', 'price' => 100],
        ]);
        dd($collection->where('price', '>', 100)->all());
//        dd($collection->last());
        dd($collection->last(function ($value) {
            return $value < 4;
        }));
    }
}
