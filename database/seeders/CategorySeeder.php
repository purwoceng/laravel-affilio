<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function getOriginCategories()
    {
        $token = config('app.baleomol_key');
        $api_endpoint = config('app.baleomol_url');
        $url = "{$api_endpoint}/categories";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get($url);

        $result = $response['data'] ?? [];

        return $result;
    }

    public function run()
    {
        $categories = [];
        $categories = $this->getOriginCategories();

        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $category_data = Category::create([
                    'origin_category_id' => $category['no'],
                    'name' => $category['name'],
                    'link' => $category['link'],
                    'description' => $category['description'],
                    'image' => '',
                    'level' => $category['level'],
                ]);
            }
        } else {
            echo "Gagal mendapatkan data kategori dari Baleomol.com. Coba lagi!";
        }
    }
}
