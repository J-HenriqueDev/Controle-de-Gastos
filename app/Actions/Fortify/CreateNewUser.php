<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Models\CategoriaGasto;
use Illuminate\Support\Facades\Auth;

use Termwind\Components\Dd;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $usuario = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $categorias = array('Conta de Luz','Conta de Agua','Conta de Internet','Pagamento de Fatura','Plano de Saude');

            foreach($categorias as $categoria){
            $nova_categoria = CategoriaGasto::create([
                'categoria_de_gastos' => $categoria,
                'user_id' => $usuario->id,
            ]);
        }

        return $usuario;
    }
}
