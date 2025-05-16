<?php
class EventoCategoria {
    private int $evento_id;
    private int $categoria_id;

    public function __construct(int $evento_id, int $categoria_id) {
        $this->evento_id = $evento_id;
        $this->categoria_id = $categoria_id;
    }

    public function getEventoId(): int {
        return $this->evento_id;
    }

    public function getCategoriaId(): int {
        return $this->categoria_id;
    }

    public function setEventoId(int $evento_id): void {
        $this->evento_id = $evento_id;
    }

    public function setCategoriaId(int $categoria_id): void {
        $this->categoria_id = $categoria_id;
    }
}
?>