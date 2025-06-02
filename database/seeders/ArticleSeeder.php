<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'titre' => 'Introduction à Laravel 10',
                'contenu' => 'Laravel 10 ....',
                'auteur' => 'John Doe',
                'date_publication' => now()->subDays(10),
            ],
            [
                'titre' => 'Les meilleures pratiques en PHP',
                'contenu' => 'Contenu ....',
                'auteur' => 'John Doe',
                'date_publication' => now()->subDays(8),
            ],
        ];

        foreach ($articles as $articleData) {
            Article::create([
                'titre' => $articleData['titre'],
                'slug' => Str::slug($articleData['titre']),
                'contenu' => $articleData['contenu'],
                'auteur' => $articleData['auteur'],
                'date_publication' => $articleData['date_publication'],
            ]);
        }

        // Génération d'articles supplémentaires pour tester la pagination
        for ($i = 1; $i <= 20; $i++) {
            Article::create([
                'titre' => "Article généré automatiquement #{$i}",
                'slug' => "article-genere-automatiquement-{$i}",
                'contenu' => "Contenu de l'article #{$i} généré automatiquement pour tester la pagination.",
                'auteur' => 'Générateur automatique',
                'date_publication' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
