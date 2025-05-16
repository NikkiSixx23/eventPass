<?php
class Usuarios {
    private int $id;
    private string $perfil;
    private string $cpf;
    private string $nome;
    private string $dataDeNascimento;
    private string $email;
    private string $senha;
    private string $telefone;

    public function __construct(
        string $perfil,
        string $cpf,
        string $nome,
        string $dataDeNascimento,
        string $email,
        string $senha,
        string $telefone
    ) {
        $this->perfil = $perfil;
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->dataDeNascimento = $dataDeNascimento;
        $this->email = $email;
        $this->senha = $senha;
        $this->telefone = $telefone;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getPerfil(): string
    {
        return $this->perfil;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDataDeNascimento(): string
    {
        return $this->dataDeNascimento;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPerfil(string $perfil): void
    {
        $this->perfil = $perfil;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setDataDeNascimento(string $dataDeNascimento): void
    {
        $this->dataDeNascimento = $dataDeNascimento;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }

    public function setTelefone(string $telefone): void
    {
        $this->telefone = $telefone;
    }
}
?>
