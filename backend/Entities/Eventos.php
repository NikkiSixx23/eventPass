<?php
class Eventos {
    private int $id;
    private string $nome;
    private string $descricao;
    private string $data_evento;
    private string $local_evento;
    private int $capacidade_maxima;
    private float $preco_ingresso;

    public function __construct(
        string $nome,
        string $descricao,
        string $data_evento,
        string $local_evento,
        int $capacidade_maxima,
        float $preco_ingresso
    ) {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->data_evento = $data_evento;
        $this->local_evento = $local_evento;
        $this->capacidade_maxima = $capacidade_maxima;
        $this->preco_ingresso = $preco_ingresso;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function getDataEvento(): string {
        return $this->data_evento;
    }

    public function getLocalEvento(): string {
        return $this->local_evento;
    }

    public function getCapacidadeMaxima(): int {
        return $this->capacidade_maxima;
    }

    public function getPrecoIngresso(): float {
        return $this->preco_ingresso;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setDescricao(string $descricao): void {
        $this->descricao = $descricao;
    }

    public function setDataEvento(string $data_evento): void {
        $this->data_evento = $data_evento;
    }

    public function setLocalEvento(string $local_evento): void {
        $this->local_evento = $local_evento;
    }

    public function setCapacidadeMaxima(int $capacidade_maxima): void {
        $this->capacidade_maxima = $capacidade_maxima;
    }

    public function setPrecoIngresso(float $preco_ingresso): void {
        $this->preco_ingresso = $preco_ingresso;
    }
}
?>