<?php


namespace App\Http\Middleware;


use App\Usuario;
use Firebase\JWT\JWT;

define('JWT_SECRET', 'dfdf685283bc4caf270b07d0753628cb');

class JwtMiddleware
{

    public function handle($request, \Closure $next, $guard = null) {
        $token = $request->get('token');

        if ( ! $token ) {
            return response()->json([
                'error' => 'Token não informado'
            ], 401);
        }

        try {
            $credenciais = JWT::decode($token, JWT_SECRET, ['HS256']);
        } catch ( \Exception $e ) {
            return response()->json([
                'error' => 'Um erro ocorreu ao tentar decodificar o token.'
            ], 401);
        }

        $request->auth = Usuario::findOrFail($credenciais->sub);

        return $next($request);
    }
}
