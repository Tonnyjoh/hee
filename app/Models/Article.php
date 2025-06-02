<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'slug',
        'contenu',
        'auteur',
        'date_publication'
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];

    /**
     * Génère automatiquement le slug à partir du titre
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->titre);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('titre') && empty($article->slug)) {
                $article->slug = Str::slug($article->titre);
            }
        });
    }

    /**
     * Scope pour les articles publiés
     */
    public function scopePublished($query)
    {
        return $query->where('date_publication', '<=', now());
    }

    /**
     * Scope pour ordonner par date de publication
     */
    public function scopeOrderByPublication($query, $direction = 'desc')
    {
        return $query->orderBy('date_publication', $direction);
    }
}
