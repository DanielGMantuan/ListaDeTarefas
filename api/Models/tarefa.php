<?php 

class Tarefa {
    private int $id;
    private string $name;
    private float $cost;
    private string $dateLimit;
    private ?int $order;

    public function buildTarefa(int $id, string $name, float $cost, string $dateLimit, int $order = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cost = $cost;
        $this->dateLimit = $dateLimit;
        $this->order = $order;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public static function fromArray(array $data): array
    {
        $tarefas = [];
        foreach ($data as $item) {
            $tarefa = new self();
            $tarefa->buildTarefa(
                $item['id'],
                $item['name'],
                (float) $item['cost'], // Converte custo para float
                $item['date_limit'],
                isset($item['presentation_order']) ? (int) $item['presentation_order'] : null
            );
            $tarefas[] = $tarefa;
        }
        return $tarefas;
    }
}

?>