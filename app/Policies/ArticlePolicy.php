<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
  public function viewAny(?User $user)
  {
    return true; // anyone can view published via component logic
  }

  public function view(?User $user, Article $article)
  {
    if ($article->status === 'published') {
      return true;
    }

    if (! $user) {
      return false;
    }

    return $user->role === 'admin' || ($user->role === 'petugas' && $user->clinic_id === $article->clinic_id);
  }

  public function create(User $user)
  {
    return in_array($user->role, ['admin', 'petugas']);
  }

  public function update(User $user, Article $article)
  {
    if ($user->role === 'admin') {
      return true;
    }

    if ($user->role === 'petugas') {
      return $user->clinic_id === $article->clinic_id;
    }

    return false;
  }

  public function delete(User $user, Article $article)
  {
    return $this->update($user, $article);
  }
}
