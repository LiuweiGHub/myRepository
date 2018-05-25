<?php
class Student
{
    public $id;

    public $name;

    protected $study;

    public function __construct($id, $name, Study $study)
    {
        $this->id = $id;
        $this->name = $name;
        $this->study = $study;
        $this->study();
    }

    public function study()
    {
        $this->name.$this->id.$this->study->show();
    }

}
