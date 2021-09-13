<?php

namespace App\Services\Reference;

use App\Models\State;

class StateService
{
  protected $state;

  public function __construct(State $state)
  {
    $this->state = $state;
  }


  public function index(object $request)
  {
    $query = $this->state->filters($request->filters);
    return (int) $request->per_page ? $query->paginate($request->per_page) : $query->get();
  }
}