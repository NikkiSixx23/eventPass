<?php
class Ingressos {
    private int $id;
    private string $evento_id;
    private string $usuario_id;
    private string $quantidade;
    private string $data_compra;
    private string $tipo_ingresso;
    private string $processo_ingresso;

    public function __construct(
        string $evento_id,
        string $usuario_id,
        string $quantidade,
        string $data_compra,
        string $tipo_ingresso,
        string $processo_ingresso
    ) {
        $this->evento_id = $evento_id;
        $this->usuario_id = $usuario_id;
        $this->quantidade = $quantidade;
        $this->data_compra = $data_compra;
        $this->tipo_ingresso = $tipo_ingresso;
        $this->processo_ingresso = $processo_ingresso;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getEventoId(): string {
        return $this->evento_id;
    }

    public function getUsuarioId(): string {
        return $this->usuario_id;
    }

    public function getQuantidade(): string {
        return $this->quantidade;
    }

    public function getDataCompra(): string {
        return $this->data_compra;
    }

    public function getTipoIngresso(): string {
        return $this->tipo_ingresso;
    }

    public function getProcessoIngresso(): string {
        return $this->processo_ingresso;
    }

    public function setEventoId(string $evento_id): void {
        $this->evento_id = $evento_id;
    }

    public function setUsuarioId(string $usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    public function setQuantidade(string $quantidade): void {
        $this->quantidade = $quantidade;
    }

    public function setDataCompra(string $data_compra): void {
        $this->data_compra = $data_compra;
    }

    public function setTipoIngresso(string $tipo_ingresso): void {
        $this->tipo_ingresso = $tipo_ingresso;
    }

    public function setProcessoIngresso(string $processo_ingresso): void {
        $this->processo_ingresso = $processo_ingresso;
    }
}
?>