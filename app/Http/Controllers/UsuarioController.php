<?php


namespace App\Http\Controllers;


use App\Http\Helper\UsuarioHelper;
use App\Usuario;
use Firebase\JWT;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

define('PASTA_IMAGENS', 'usuario');
define('JWT_SECRET', 'dfdf685283bc4caf270b07d0753628cb');
define('NIVEL_CANDIDATO', 2);
define('NIVEL_MODERADOR', 1);

class UsuarioController extends Controller {
    /**
     * Retorna todos os usuários cadastrados
     *
     * @return Usuario[]|Collection
     */
    public function index(){
        return Usuario::all();
    }

    /**
     * Retorna um usuário específico
     * pelo código
     *
     * @param int $codUsuario
     * @return mixed
     */
    public function show(int $codUsuario){
        return Usuario::find($codUsuario);
    }

    /**
     * Adiciona um novo usuário
     *
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function store(Request $request){
        $usuario = $this->validate($request, Usuario::$rules);

        $usuario['fotoUsuario'] = $this->uploadFoto($request->foto, $request->codNivelUsuario);
        $usuario['password']    = password_hash($request->password, PASSWORD_BCRYPT);
        $usuario = Usuario::create($usuario);

        return $usuario->codUsuario;
    }

    /**
     * Atualiza um usuário
     *
     * @param Request $request
     * @param int $codUsuario
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codUsuario){
        $this->validate($request, Usuario::$rules);

        $usuario = Usuario::findOrFail($codUsuario);

        if ( $request->has('foto') ) {
            $this->deletaImagem($usuario['fotoUsuario'], PASTA_IMAGENS);
            $request->fotoUsuario = $this->uploadFoto($request->foto, $usuario->codNivelUsuario);
        }

        $request->password = password_hash($request->password, PASSWORD_BCRYPT);
        $usuario->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um usuário
     *
     * @param int $codUsuario
     * @return JsonResponse
     */
    public function destroy(int $codUsuario){
        Usuario::destroy($codUsuario);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Autentica um usuário e retorna o token
     *
     * @param string $user
     * @param string $password
     * @return bool|string
     */
    public function authenticateUser(string $user, string $password){
        $usuario = $this->getUsuarioPorUser($user);

        if ( ! $usuario ) {
            return response()->json([
                'error' => 'Usuário não encontrado'
            ], 404);
        }

        if (password_verify($password, $usuario->getAttribute('password'))) {
            return response()->json([
                'codUsuario' => $usuario->codUsuario,
                'codEndereco' => $usuario->codEndereco,
                'token' => $this->jwt($usuario)
            ]);
        }

        return response()->json([
            'error' => 'Senha incorreta'
        ], 403);
    }

    /**
     * Função que retorna um usuário pelo id
     *
     * @param string $user
     * @return mixed
     */
    public function getUsuarioPorUser(string $user) {
        return Usuario::where('loginUsuario', $user)->first();
    }

    public function getUsuarioPorEmail(string $email) {
        return Usuario::where('email', $email)->first();
    }

    public function findUser(Request $request){
        if ($request->loginUsuario) {
            $user = $request->loginUsuario;
            return $this->getUsuarioPorUser($user);
        }
        if ($request->email) {
            $email = $request->email;
            return $this->getUsuarioPorEmail($email);
        }
    }

    /**
     * Recebe os dados do login e envia para
     * autenticação
     *
     * @param Request $request
     * @return bool|string
     */
    public function login(Request $request) {
        $user     = $request->user;
        $password = $request->password;

        return $this->authenticateUser($user, $password);
    }

    protected function jwt(Usuario $usuario) {
        $payload = [
            'iss'         => 'lumen-jwt',
            'cod'         => $usuario->getAttribute('codUsuario'),
            'foto'        => $usuario->getAttribute('fotoUsuario'),
            'nivel'       => $usuario->getAttribute('codNivelUsuario'),
            'nome'        => UsuarioHelper::getNomeUsuario($usuario)[0]->nomeUsuario,
            'username'    => $usuario->getAttribute('loginUsuario'),
            'iat'         => time()
        ];

        return JWT\JWT::encode($payload, JWT_SECRET);
    }

    /**
     * Realiza o upload de foto escolhida
     * ou seta a padrão para cada tipo de
     * usuário
     *
     * @param $imagem
     * @param int $codNivelUsuario
     * @return string
     */
    private function uploadFoto($imagem, int $codNivelUsuario){
        // Se o usuário não selecionou uma foto
        if ( $imagem != null ) {
            return $this->uploadImagem($imagem, 300, 300, PASTA_IMAGENS);
        }

        // Se o usuário não selecionou nenhuma foto
        // e é um candidato
        if ( ($codNivelUsuario == NIVEL_CANDIDATO) || ($codNivelUsuario == NIVEL_MODERADOR) ) {
            return 'perfil.png';
        }
    }
}
