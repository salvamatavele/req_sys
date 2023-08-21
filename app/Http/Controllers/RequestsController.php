<?php

namespace App\Http\Controllers;

use App\Mail\RequestDoneMail;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use stdClass;
use Twilio\Rest\Client;

class RequestsController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 0 || auth()->user()->role == 1) {
            $requests = ModelsRequest::all()->load('users.user');
            return view('requests.index', [
                "requests" => $requests,
                'pending' => sizeof(ModelsRequest::where('status', 0)->get()),
                'in_progress' => sizeof(ModelsRequest::where('status', 1)->get()),
                'done' => sizeof(ModelsRequest::where('status', 2)->get()),
                'rejected' => sizeof(ModelsRequest::where('status', 3)->get()),
            ]);
        } else {
            $data = User::find(auth()->user()->id)->load('requests.request');

            return view('requests.index_personal', [
                "data" => $data,
                'pending' => sizeof(UserRequest::where('user_id', auth()->user()->id)->where('status', 0)->get()),
                'in_progress' => sizeof(UserRequest::where('user_id', auth()->user()->id)->where('status', 1)->get()),
                'done' => sizeof(UserRequest::where('user_id', auth()->user()->id)->where('status', 2)->get()),
                'rejected' => sizeof(UserRequest::where('user_id', auth()->user()->id)->where('status', 3)->get()),
            ]);
        }
    }
    public function create()
    {
        return view('requests.create');
    }

    public function store(Request $requestsRequest)
    {
        $file = $requestsRequest->file('doc');
        $data = $requestsRequest->all();
        if (is_file($file)) {

            $name = $file->hashName();
            $extension = $file->extension();
            $file->move("storage/doc", $name);
            $data['doc'] = $name;
        }
        $request = ModelsRequest::create($data);
        if ($request) {
            return Redirect::route('requests.index')->with('success', "O seu pedido foi guardado com sucesso.");
        } else {
            return Redirect::route('requests.create')->with('error', "Ooops! Erro ao tentar guardar o pedido, por favor tente novamente.");
        }
    }

    public function send(int $id)
    {
        $users = User::where('role', 2)->with(['requests' => function (Builder $query) {
            $query->where('status', '=', 0);
        }])->get();
        return view('requests.send', [
            'users' => $users,
            'request_id' => $id,
            'pending' => sizeof(ModelsRequest::where('status', 0)->get()),
            'in_progress' => sizeof(ModelsRequest::where('status', 1)->get()),
            'done' => sizeof(ModelsRequest::where('status', 2)->get()),
            'rejected' => sizeof(ModelsRequest::where('status', 3)->get()),
        ]);
    }

    public function storeSend(Request $request)
    {
        $userRequest = UserRequest::create($request->all());
        if ($userRequest) {
            $this_request = ModelsRequest::find($request->input('request_id'));
            if (!$this_request->update(['status' => 1])) {
                UserRequest::destroy($userRequest->id);
            }
            return Redirect::route('requests.index')->with('success', "O documento foi submetido com sucesso");
        } else {
            return Redirect::route('requests.index')->with('error', "Ooops! Erro ao tentar submeter o documento, por favor tente novamente.");
        }
    }

    public function inProgress(int $id)
    {
        $request = UserRequest::find($id);
        if ($request->update(['status' => 1])) {
            return redirect()->back()->with('success', "O progresso foi alterado com sucesso");
        } else {
            return redirect()->back()->with('error', "Ooops! Erro ao tentar alterar o progresso. Tente novamente.");
        }
    }

    public function done(int $id)
    {
        $userRequest = UserRequest::find($id);
        if ($userRequest->update(['status' => 2, 'active' => 0])) {
            if (auth()->user()->role == 3) {
                $request = ModelsRequest::find($userRequest->request_id);
                $request->update(['status' => 2]);
                $twilio = new Client(getenv('TWILIO_SID'), getenv('TWILIO_KEY'));
                $twilio->messages->create(
                    "+258842023448", // to
                    [
                        "body" => "E com grande prazer que informamos que o seu requerimento foi aceite e esta pronto para o levantamento. Cumprimentos",
                        "from" => getenv('TWILIO_MASTER_PHONE'),
                    ]
                );
            }
            return redirect()->back()->with('success', "O progresso foi alterado com sucesso");
        } else {
            return redirect()->back()->with('error', "Ooops! Erro ao tentar alterar o progresso. Tente novamente.");
        }
    }

    public function reject(int $id)
    {
        $userRequest = UserRequest::find($id);
        if ($userRequest->update(['status' => 3, 'active' => 0])) {
            $request = ModelsRequest::find($userRequest->request_id);
            $request->update(['status' => 3]);
            $twilio = new Client(getenv('TWILIO_SID'), getenv('TWILIO_KEY'));
            $twilio->messages->create(
                "+258842023448", // to
                [
                    "body" => "Lamentamos informar que por alguma razão o seu requerimento foi rejeitado.",
                    "from" => getenv('TWILIO_MASTER_PHONE'),
                ]
            );
            return redirect()->back()->with('success', "O progresso foi alterado com sucesso");
        } else {
            return redirect()->back()->with('error', "Ooops! Erro ao tentar alterar o progresso. Tente novamente.");
        }
    }

    public function reset(int $id)
    {
        $request = UserRequest::find($id);
        if ($request->update(['status' => 0])) {
            return redirect()->back()->with('success', "O progresso foi alterado com sucesso");
        } else {
            return redirect()->back()->with('error', "Ooops! Erro ao tentar alterar o progresso. Tente novamente.");
        }
    }

    public function sendTo(int $id)
    {
        $users = User::where('role', 3)->with(['requests' => function (Builder $query) {
            $query->where('status', '=', 0);
        }])->get();
        return view('requests.send_to', [
            'users' => $users,
            'user_request_id' => $id,
            'pending' => sizeof(UserRequest::where('user_id', auth()->user()->id)->where('status', 0)->get()),
            'in_progress' => sizeof(UserRequest::where('user_id', auth()->user()->id)->where('status', 1)->get()),
            'done' => sizeof(UserRequest::where('user_id', auth()->user()->id)->where('status', 2)->get()),
            'rejected' => sizeof(UserRequest::where('user_id', auth()->user()->id)->where('status', 3)->get()),
        ]);
    }

    public function storeSendTo(Request $request)
    {
        $this_request = UserRequest::find($request->input('user_request_id'));
        if ($this_request->update(['active' => 0])) {
            $data = ['user_id' => $request->input('user_id'), 'request_id' => $this_request->request_id];
            $userRequest = UserRequest::create($data);
            if ($userRequest) {
                return Redirect::route('requests.index')->with('success', "O documento foi submetido com sucesso");
            } else {
                return Redirect::route('requests.index')->with('error', "Ooops! Erro ao tentar submeter o documento, por favor tente novamente.");
            }
        } else {
            return Redirect::route('requests.index')->with('error', "Ooops! Erro ao tentar submeter o documento, por favor tente novamente.");
        }
    }

    public function delete(int $id)
    {
        try {
            ModelsRequest::destroy($id);
            return Redirect::back()->with('success', "Requerimento eliminado com sucesso.");
        } catch (\Throwable $e) {
            return Redirect::back()->with('error', "Ooops! Erro ao tentar eliminar o requerimento, tente novamente.");
        }
    }

    public function deleteUserRequest(int $id)
    {
        try {
            UserRequest::destroy($id);
            return Redirect::back()->with('success', "Requerimento eliminado com sucesso.");
        } catch (\Throwable $e) {
            return Redirect::back()->with('error', "Ooops! Erro ao tentar eliminar o requerimento, tente novamente.");
        }
    }
}
