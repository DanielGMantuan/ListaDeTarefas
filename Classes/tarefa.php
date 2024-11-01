<?php 

class Tarefa {
    private int $id;
    private string $name;
    private float $cost;
    private DateTime $dateLimit;
    private int $order;

    public function buildTarefa(int $id, string $name, float $cost, DateTime $dateLimit, int $order)
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
}

?>