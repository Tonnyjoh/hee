<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Affiche la liste paginée des articles
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $perPage = min($perPage, 50);

            $articles = Article::published()
                ->orderByPublication()
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $articles->items(),
                'pagination' => [
                    'current_page' => $articles->currentPage(),
                    'last_page' => $articles->lastPage(),
                    'per_page' => $articles->perPage(),
                    'total' => $articles->total(),
                    'from' => $articles->firstItem(),
                    'to' => $articles->lastItem(),
                    'has_more_pages' => $articles->hasMorePages(),
                ],
                'links' => [
                    'first' => $articles->url(1),
                    'last' => $articles->url($articles->lastPage()),
                    'prev' => $articles->previousPageUrl(),
                    'next' => $articles->nextPageUrl(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des articles',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur est survenue'
            ], 500);
        }
    }

    /**
     * Affiche un article spécifique
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $article = Article::where('slug', $slug)->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $article
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Article non trouvé'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'article',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur est survenue'
            ], 500);
        }
    }

    /**
     * Crée un nouvel article
     */
    public function store(ArticleRequest $request): JsonResponse
    {
        try {
            $article = Article::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Article créé avec succès',
                'data' => $article
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'article',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur est survenue'
            ], 500);
        }
    }

    /**
     * Met à jour un article existant
     */
    public function update(ArticleRequest $request, Article $article): JsonResponse
    {
        try {
            $article->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Article mis à jour avec succès',
                'data' => $article->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'article',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur est survenue'
            ], 500);
        }
    }

    /**
     * Supprime un article
     */
    public function destroy(Article $article): JsonResponse
    {
        try {
            $article->delete();

            return response()->json([
                'success' => true,
                'message' => 'Article supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'article',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur est survenue'
            ], 500);
        }
    }
}
