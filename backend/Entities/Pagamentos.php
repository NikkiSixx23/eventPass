<?php
class Pagamentos {
    private ?int $id = null;
    private int $ingresso_id;
    private string $metodo_pagamento;
    private float $valor_total;
    private string $status_pagamento;
    private string $data_pagamento; 

    public function __construct(
        int $ingresso_id,
        string $metodo_pagamento,
        float $valor_total,
        string $status_pagamento,
        string $data_pagamento
    ) {
        $this->ingresso_id = $ingresso_id;
        $this->metodo_pagamento = $metodo_pagamento;
        $this->valor_total = $valor_total;
        $this->status_pagamento = $status_pagamento;
        $this->data_pagamento = $data_pagamento;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getIngressoId(): int {
        return $this->ingresso_id;
    }

    public function getMetodoPagamento(): string {
        return $this->metodo_pagamento;
    }

    public function getValorTotal(): float {
        return $this->valor_total;
    }

    public function getStatusPagamento(): string {
        return $this->status_pagamento;
    }

    public function getDataPagamento(): string {
        return $this->data_pagamento;
    }

    public function setMetodoPagamento(string $metodo_pagamento): void {
        $this->metodo_pagamento = $metodo_pagamento;
    }

    public function setValorTotal(float $valor_total): void {
        $this->valor_total = $valor_total;
    }

    public function setStatusPagamento(string $status_pagamento): void {
        $this->status_pagamento = $status_pagamento;
    }

    public function setDataPagamento(string $data_pagamento): void {
        $this->data_pagamento = $data_pagamento;
    }
}
?>