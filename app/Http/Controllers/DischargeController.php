<?php

namespace App\Http\Controllers;

use App\Http\Requests\DischargeRequest;
use App\Models\Discharge;
use Illuminate\Support\Facades\Redirect;

class DischargeController extends Controller
{
    public function __construct(
        protected Discharge $model
    ){}
    public function store(DischargeRequest $request)
    {
        $file = $request->file('doc');
        $data = $request->validated();
        if (is_file($file)) {

            $name = $file->hashName();
            $file->move("storage/doc", $name);
            $data['doc'] = $name;
        }
        $discharge = $this->model->create($data);
        if ($discharge) {
            return Redirect::route('requests.index')->with('success', "A sua quitacao foi carregada com sucesso.");
        } else {
            return Redirect::route('requests.create')->with('error', "Ooops! Erro ao tentar carregar a quitacao, por favor tente novamente.");
        }
    }
    public function delete(int $id)
    {
        try {
            $this->model->destroy($id);
            return Redirect::back()->with('success', "Quitacao eliminada com sucesso.");
        } catch (\Throwable $e) {
            return Redirect::back()->with('error', "Ooops! Erro ao tentar eliminar a quitacao, tente novamente.");
        }
    }
}
