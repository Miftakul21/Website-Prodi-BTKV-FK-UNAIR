<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Berita;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        $sitemap->add(Url::create('/'));
        $sitemap->add(Url::create('/berita'));

        Berita::all()->each(function ($berita) use ($sitemap) {
            $sitemap->add(
                Url::create("/berita/{$berita->slug}")
                    ->setLastModificationDate($berita->updated_at)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
