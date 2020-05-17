<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //STATUS CANDIDATURA
        DB::table('tbStatusCandidatura')->insert([
            [
              'codStatusCandidatura'  => 1,
              'nomeStatusCandidatura' => 'Aprovado',
            ],
            [
              'codStatusCandidatura'  => 2,
              'nomeStatusCandidatura' => 'Em análise',
            ],
            [
              'codStatusCandidatura'  => 3,
              'nomeStatusCandidatura' => 'Recusado',
            ],
        ]);

        //NIVEL USUARIO
        DB::table('tbNivelUsuario')->insert([
    		[
        		'codNivelUsuario'  => 1,
                'nomeNivelUsuario' => 'Moderador',
    		],
    		[
              'codNivelUsuario'  => 2,
              'nomeNivelUsuario' => 'Candidato',

    		],
    		[
              'codNivelUsuario'  => 3,
              'nomeNivelUsuario' => 'Empresa',
    		],
    	]);

        //ENDEREÇOS
        DB::table('tbEndereco')->insert([
    		[
    		    'codEndereco'         => 1,
                'cepEndereco'         => '01538001',
                'logradouroEndereco'  => 'Avenida Lins de Vasconcelos',
                'numeroEndereco'      => '1222',
                'complementoEndereco' => ' ',
                'bairroEndereco'      => 'Cambuci',
                'zonaEndereco'        => 'Zona Central',
                'cidadeEndereco'      => 'São Paulo',
                'estadoEndereco'      => 'SP',
    		],
            [
                'codEndereco'         => 2,
                'cepEndereco'         => '04044001',
                'logradouroEndereco'  => 'Rua Machado Bitencourt',
                'numeroEndereco'      => '361',
                'complementoEndereco' => 'Sala 1110',
                'bairroEndereco'      => 'Vila Clementino',
                'zonaEndereco'        => 'Zona Sul',
                'cidadeEndereco'      => 'São Paulo',
                'estadoEndereco'      => 'SP',
            ],
            [
                'codEndereco'         => 3,
                'cepEndereco'         => '05425902',
                'logradouroEndereco'  => 'Avenida Doutora Ruth Cardoso',
                'numeroEndereco'      => '7221',
                'complementoEndereco' => ' ',
                'bairroEndereco'      => 'Pinheiros',
                'zonaEndereco'        => 'Zona Oeste',
                'cidadeEndereco'      => 'São Paulo',
                'estadoEndereco'      => 'SP',
            ],
            [
                'codEndereco'         => 4,
                'cepEndereco'         => '04002032',
                'logradouroEndereco'  => 'Rua Teixeira da Silva',
                'numeroEndereco'      => '531',
                'complementoEndereco' => ' ',
                'bairroEndereco'      => 'Paraíso',
                'zonaEndereco'        => 'Zona Sul',
                'cidadeEndereco'      => 'São Paulo',
                'estadoEndereco'      => 'SP',
            ],
            [
                'codEndereco'         => 5,
                'cepEndereco'         => '01418100',
                'logradouroEndereco'  => 'Alameda Santos',
                'numeroEndereco'      => '1054',
                'complementoEndereco' => ' ',
                'bairroEndereco'      => 'Jardim Paulista',
                'zonaEndereco'        => 'Zona Sul',
                'cidadeEndereco'      => 'São Paulo',
                'estadoEndereco'      => 'SP',
            ],
        ]);

        //USUARIOS
        DB::table('tbUsuario')->insert(array(
            //Empresas
        	[
            	'codUsuario'      => 1,
                'fotoUsuario'     => 'empresa-colegio.jpg',
                'loginUsuario'    => 'Education & Future',
                'password'        => '$2y$10$UGYW4JK2i.8Jv1IQdHpZdu9hX.HwIXukFjpZxYcS5Y.KPEqciHNai',
                'email'           =>'education@future.com.br',
                'codNivelUsuario' => 3,
                'codEndereco'     => 1,
        	],
            [
                'codUsuario'      => 2,
                'fotoUsuario'     => 'claro.jpg',
                'loginUsuario'    => 'Claro',
                'password'        => '$2y$10$UGYW4JK2i.8Jv1IQdHpZdu9hX.HwIXukFjpZxYcS5Y.KPEqciHNai',
                'email'           =>'claro@telefonia.com.br',
                'codNivelUsuario' => 3,
                'codEndereco'     => 2,
            ],
            [
                'codUsuario'      => 3,
                'fotoUsuario'     => 'linx.jpg',
                'loginUsuario'    => 'Linx',
                'password'        => '$2y$10$UGYW4JK2i.8Jv1IQdHpZdu9hX.HwIXukFjpZxYcS5Y.KPEqciHNai',
                'email'           =>'linx@software.com.br',
                'codNivelUsuario' => 3,
                'codEndereco'     => 3,
            ],
            [
                'codUsuario'      => 4,
                'fotoUsuario'     => 'cia-terra.jpg',
                'loginUsuario'    => 'ciaTerra',
                'password'        => '$2y$10$UGYW4JK2i.8Jv1IQdHpZdu9hX.HwIXukFjpZxYcS5Y.KPEqciHNai',
                'email'           =>'cia@terra.com.br',
                'codNivelUsuario' => 3,
                'codEndereco'     => 4,
            ],
            [
                'codUsuario'      => 5,
                'fotoUsuario'     => 'starbucks.png',
                'loginUsuario'    => 'starbucks',
                'password'        => '$2y$10$UGYW4JK2i.8Jv1IQdHpZdu9hX.HwIXukFjpZxYcS5Y.KPEqciHNai',
                'email'           =>'starbucks@gmail.com.br',
                'codNivelUsuario' => 3,
                'codEndereco'     => 5,
            ],

            //Candidatos
            [
        		    'codUsuario'      => 6,
                'fotoUsuario'     => 'perfil.png',
                'loginUsuario'    => 'Candidato',
                'password'        => '$2y$10$Wrjg/tHTvKekdW5Qc/k4S.BrIJVVfWe0B1MoJ.EVarRbQMzkrw.Ii',
                'email'           => 'candidato@example.com',
                'codNivelUsuario' => 2,
                'codEndereco'     => 1,
        	],
        ));

        //EMPRESAS
        DB::table('tbEmpresa')->insert([
        	[
            	'codEmpresa'          => 1,
                'razaoSocialEmpresa'  => 'Education & Future',
                'nomeFantasiaEmpresa' => 'Education & Future',
                'cnpjEmpresa'         => '76627089000182',
                'codUsuario'          => 1,
    	   ],
           [
                'codEmpresa'          => 2,
                'razaoSocialEmpresa'  => 'Claro',
                'nomeFantasiaEmpresa' => 'Claro',
                'cnpjEmpresa'         => '40432544000147',
                'codUsuario'          => 2,
           ],
           [
                'codEmpresa'          => 3,
                'razaoSocialEmpresa'  => 'Linx Sistemas e Consultoria',
                'nomeFantasiaEmpresa' => 'Linx',
                'cnpjEmpresa'         => '54517628000198',
                'codUsuario'          => 3,
           ],
           [
                'codEmpresa'          => 4,
                'razaoSocialEmpresa'  => 'CIA Terra',
                'nomeFantasiaEmpresa' => 'CIA Terra',
                'cnpjEmpresa'         => '03409936000169',
                'codUsuario'          => 4,
           ],
           [
                'codEmpresa'          => 5,
                'razaoSocialEmpresa'  => 'Starbucks',
                'nomeFantasiaEmpresa' => 'STARBUCKS BRASIL COMERCIO DE CAFES LTDA',
                'cnpjEmpresa'         => '07984267000100',
                'codUsuario'          => 5,
           ],
        ]);

        //CANDIDATOS
        DB::table('tbCandidato')->insert([
    	   [
        	    'codCandidato'            => 1,
                'nomeCandidato'           => 'Candidato',
                'cpfCandidato'            => '12345678901',
                'rgCandidato'             => '123',
                'dataNascimentoCandidato' => '895795200',
                'codUsuario'              => 6,
    	   ],
        ]);


        //TIPOS ADICIONAIS
        DB::table('tbTipoAdicional')->insert([
    		[
        		'codTipoAdicional'         => 1,
                'nomeTipoAdicional'        => 'Habilidade',
                'escalonavelTipoAdicional' => 0,
    		],
            [
        		'codTipoAdicional'         => 2,
                'nomeTipoAdicional'        => 'Escolaridade',
                'escalonavelTipoAdicional' => 1,
    		],
            [
            	'codTipoAdicional'         => 3,
                'nomeTipoAdicional'        => 'Alfabetização',
                'escalonavelTipoAdicional' => 1,
    		],
    	]);

        //ADICIONAIS
        DB::table('tbAdicional')->insert([
    		[
        		'codAdicional'     => 1,
                'imagemAdicional'  => 'comunicativo.png',
                'nomeAdicional'    => 'Comunicação',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 2,
                'imagemAdicional'  => 'criativo.png',
                'nomeAdicional'    => 'Criatividade',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 3,
                'imagemAdicional'  => 'organizacao.png',
                'nomeAdicional'    => 'Organização',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 4,
                'imagemAdicional'  => 'relacionamento.png',
                'nomeAdicional'    => 'Relacionamento',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 5,
                'imagemAdicional'  => 'matematica.png',
                'nomeAdicional'    => 'Números',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 6,
                'imagemAdicional'  => 'escrita.png',
                'nomeAdicional'    => 'Escrita',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 7,
                'imagemAdicional'  => 'instrumento.png',
                'nomeAdicional'    => 'Música',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 8,
                'imagemAdicional'  => 'pintura.png',
                'nomeAdicional'    => 'Artes',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 9,
                'imagemAdicional'  => 'camera.png',
                'nomeAdicional'    => 'Fotografia',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 10,
                'imagemAdicional'  => 'baby.png',
                'nomeAdicional'    => 'Crianças',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 11,
                'imagemAdicional'  => 'inteligente.png',
                'nomeAdicional'    => 'Raciocínio',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 12,
                'imagemAdicional'  => 'html.png',
                'nomeAdicional'    => 'Códigos',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 1,
    		],
            [
        		'codAdicional'     => 13,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Ensino Fundamental Incompleto',
                'grauAdicional'    => 10,
                'codTipoAdicional' => 2,
    		],
            [
        		'codAdicional'     => 14,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Ensino Fundamental Completo',
                'grauAdicional'    => 20,
                'codTipoAdicional' => 2,
    		],
            [
        		'codAdicional'     => 15,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Ensino Médio Incompleto',
                'grauAdicional'    => 30,
                'codTipoAdicional' => 2,
    		],
            [
        		'codAdicional'     => 16,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Ensino Médio Completo',
                'grauAdicional'    => 40,
                'codTipoAdicional' => 2,
    		],

            [
        		'codAdicional'     => 17,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Ensino Superior Incompleto',
                'grauAdicional'    => 50,
                'codTipoAdicional' => 2,
    		],
            [
        		'codAdicional'     => 18,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Ensino Superior Completo',
                'grauAdicional'    => 60,
                'codTipoAdicional' => 2,
    		],
            [
        		'codAdicional'     => 19,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Alfabetizado',
                'grauAdicional'    => 100,
                'codTipoAdicional' => 3,
    		],
            [
        		'codAdicional'     => 20,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Semi-Analfabeto',
                'grauAdicional'    => 50,
                'codTipoAdicional' => 3,
    		],
            [
        		'codAdicional'     => 21,
                'imagemAdicional'  => ' ',
                'nomeAdicional'    => 'Analfabeto',
                'grauAdicional'    => 0,
                'codTipoAdicional' => 3,
    		],
    	]);

        //CATEGORIAS
        DB::table('tbCategoria')->insert([
    		[
        		'codCategoria'    => 1,
                'imagemCategoria' => 'telemarketing.png',
                'nomeCategoria'   => 'Atendimento',
    		],
            [
        		'codCategoria'    => 2,
                'imagemCategoria' => 'ti.png',
                'nomeCategoria'   => 'TI',
    		],
            [
        		'codCategoria'    => 3,
                'imagemCategoria' => 'assistencia-tecnica.png',
                'nomeCategoria'   => 'Assistência Técnica',
    		],
            [
        		'codCategoria'    => 4,
                'imagemCategoria' => 'livros.png',
                'nomeCategoria'   => 'Educação',
    		],
            [
    		    'codCategoria'    => 5,
                'imagemCategoria' => 'danca.png',
                'nomeCategoria'   => 'Dança',
    		],
            [
        		'codCategoria'    => 6,
                'imagemCategoria' => 'alimentacao.png',
                'nomeCategoria'   => 'Alimentação',
        	],
            [
        		'codCategoria'    => 7,
                'imagemCategoria' => 'artes.png',
                'nomeCategoria'   => 'Artes',
        	],
            [
        		'codCategoria'    => 8,
                'imagemCategoria' => 'musica.png',
                'nomeCategoria'   => 'Música',
        	],
            [
        		'codCategoria'    => 9,
                'imagemCategoria' => 'saude.png',
                'nomeCategoria'   => 'Saúde',
        	],
            [
        		'codCategoria'    => 10,
                'imagemCategoria' => 'eventos.png',
                'nomeCategoria'   => 'Eventos',
        	],
            [
        		'codCategoria'    => 11,
                'imagemCategoria' => 'obra.png',
                'nomeCategoria'   => 'Construção',
        	],
            [
        		'codCategoria'    => 12,
                'imagemCategoria' => 'beleza.png',
                'nomeCategoria'   => 'Beleza',
        	],
            [
        		'codCategoria'    => 13,
                'imagemCategoria' => 'esportes.png',
                'nomeCategoria'   => 'Esportes',
        	],
            [
        		'codCategoria'    => 14,
                'imagemCategoria' => 'vendas.png',
                'nomeCategoria'   => 'Vendas',
        	],
        ]);

        //PROFISSÃO
        DB::table('tbProfissao')->insert([
    		[
        		'codProfissao'  => 1,
                'nomeProfissao' => 'Professor de Matemática',
                'codCategoria'  => 4,
    		],
            [
                'codProfissao'  => 2,
                'nomeProfissao' => 'Operador de Telemarketing',
                'codCategoria'  => 1,
            ],
            [
                'codProfissao'  => 3,
                'nomeProfissao' => 'Programador Fullstack',
                'codCategoria'  => 2
            ],
            [
                'codProfissao'  => 4,
                'nomeProfissao' => 'Professor de Dança',
                'codCategoria'  => 5
            ],
            [
                'codProfissao'  => 5,
                'nomeProfissao' => 'Barista',
                'codCategoria'  => 6
            ],
    	]);

        //REGIME CONTRATAÇÃO
        DB::table('tbRegimeContratacao')->insert([
    		[
        		'codRegimeContratacao'  => 1,
                'nomeRegimeContratacao' => 'Empregado',
    		],
            [
        		'codRegimeContratacao'  => 2,
                'nomeRegimeContratacao' => 'Trainee',
    		],
            [
        		'codRegimeContratacao'  => 3,
                'nomeRegimeContratacao' => 'Jovem aprendiz',
    		],
            [
        		'codRegimeContratacao'  => 4,
                'nomeRegimeContratacao' => 'Estagiário',
    		],
    	]);

        //VAGAS
        DB::table('tbVaga')->insert([
    	   [
    	      'codVaga'               => 1,
            'descricaoVaga'        => 'Irá ministrar aula, fazer planejamento, preencher relatórios, fazer provas e trabalhos, semanário e trabalhar com projetos.',
            'salarioVaga'          => 2,
            'cargaHorariaVaga'     => '44:00:00',
            'quantidadeVaga'       => 5,
            'codEmpresa'           => 1,
            'codProfissao'         => 1,
            'codEndereco'          => 1,
            'codRegimeContratacao' => 1,
    	   ],
           [
            'codVaga'                  => 2,
            'descricaoVaga'            => 'Realizar ligações para nossos clientes através de nossa central de Televendas, ofertar os produtos da NET & Claro (TV a cabo, internet banda larga, telefônia fixa e móvel)',
            'salarioVaga'              => 1500,
            'cargaHorariaVaga'         => '44:00:00',
            'quantidadeVaga'           => 15,
            'codEmpresa'               => 2,
            'codProfissao'             => 2,
            'codEndereco'              => 2,
            'codRegimeContratacao'     => 1,
           ],
           [
            'codVaga'                  => 3,
            'descricaoVaga'            => 'Criar a plataforma de anúncios e produtos patrocinados que integram os produtos da Linx Impulse seguindo as necessidades e padrões elevados de exigência dos nossos clientes, criando um código de qualidade, escalável e proporcionando a melhor experiência ao cliente final',
            'salarioVaga'              => 2500,
            'cargaHorariaVaga'         => '44:00:00',
            'quantidadeVaga'           => 1,
            'codEmpresa'               => 3,
            'codProfissao'             => 3,
            'codEndereco'              => 3,
            'codRegimeContratacao'     => 4,
           ],
           [
            'codVaga'                  => 4,
            'descricaoVaga'            => 'Lecionar aulas de dança para iniciantes',
            'salarioVaga'              => 3000,
            'cargaHorariaVaga'         => '20:00:00',
            'quantidadeVaga'           => 1,
            'codEmpresa'               => 4,
            'codProfissao'             => 4,
            'codEndereco'              => 4,
            'codRegimeContratacao'     => 1,
           ],
           [
            'codVaga'                  => 5,
            'descricaoVaga'            => 'Se você tem interesse em fazer parte de uma empresa onde você pode impactar pessoas, viver seus valores e desfrutar de grandes oportunidades, gostaríamos de te conhecer.',
            'salarioVaga'              => 1500,
            'cargaHorariaVaga'         => '44:00:00',
            'quantidadeVaga'           => 1,
            'codEmpresa'               => 5,
            'codProfissao'             => 5,
            'codEndereco'              => 5,
            'codRegimeContratacao'     => 3,
           ],
        ]);

        //REQUISITOS
        DB::table('tbRequisitoVaga')->insert([
        	[
        	    'codRequisitoVaga'             => 1,
                'obrigatoriedadeRequisitoVaga' => 0,
                'codAdicional'                 => 1,
                'codVaga'                      => 1,
        	],
            [
        		'codRequisitoVaga'             => 2,
                'obrigatoriedadeRequisitoVaga' => 0,
                'codAdicional'                 => 6,
                'codVaga'                      => 1,
        	],
            [
        		'codRequisitoVaga'             => 3,
                'obrigatoriedadeRequisitoVaga' => 0,
                'codAdicional'                 => 11,
                'codVaga'                      => 1,
        	],
            [
        		'codRequisitoVaga'             => 4,
                'obrigatoriedadeRequisitoVaga' => 1,
                'codAdicional'                 => 10,
                'codVaga'                      => 1,
        	],
            [
                'codRequisitoVaga'             => 5,
                'obrigatoriedadeRequisitoVaga' => 1,
                'codAdicional'                 => 3,
                'codVaga'                      => 5,
            ],
            [
                'codRequisitoVaga'             => 6,
                'obrigatoriedadeRequisitoVaga' => 0,
                'codAdicional'                 => 4,
                'codVaga'                      => 5,
            ],
    	]);

      //Beneficios
      DB::table('tbBeneficio')->insert([
        [
          'codBeneficio'  => 1,
          'nomeBeneficio' => "Vale Transporte",
          'codVaga'       => 5,
        ],
        [
          'codBeneficio'  => 2,
          'nomeBeneficio' => "Vale Alimentação",
          'codVaga'       => 5,
        ],
        [
          'codBeneficio'  => 3,
          'nomeBeneficio' => "Assistência Médica",
          'codVaga'       => 5,
        ],
    ]);
    }
}
