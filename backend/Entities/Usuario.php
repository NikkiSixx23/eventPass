<?php
    class Usuario {
        private int $id;
        private String $perfil;
        private String $cpf;
        private String $nome;
        private String $dataDeNascimento;
        private String $email;
        private String $senha;
        private String $telefone;
        private String $endereco;

        public function __construct(String $cpf, String $nome, String $dataDeNascimento, String $email, String $senha, String $telefone = 'Não informado', String $endereco = 'Não informado', String $perfil = 'USUARIO') {
            $this->perfil = $perfil;
            $this->cpf = $cpf;
            $this->nome = $nome;
            $this->dataDeNascimento = $dataDeNascimento;
            $this->email = $email;
            $this->senha = $senha;
            $this->telefone = $telefone;
            $this->endereco = $endereco;
        }

        public function validaUsuario($email, $senha) {
            if ($email == $this->email && $senha == $this->senha) {
                return true;
            } else {
                return false;
            }
        }

        public function getId(): int {
            return $this->id;
        }

        public function getCpf(): String {
            return $this->cpf;
        }

        public function getNome(): String {
            return $this->nome;
        }

        public function getDataNascimento(): String {
            return $this->dataDeNascimento;
        }

        public function getEmail(): String {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function getSenha(): String {
            return $this->senha;
        }

        public function setSenha($senha) {
            $this->senha = $senha;
        }

        public function getTelefone(): String {
            return $this->telefone;
        }

        public function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        public function getPerfil(): String {
            return $this->perfil;
        }

        public function setPerfil($perfil) {
            $this->perfil = $perfil;
        }

        public function getEndereco(): String {
            return $this->endereco;
        }

        public function setEndereco($endereco) {
            $this->endereco = $endereco;
        }
    }
?>