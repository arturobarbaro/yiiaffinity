<?php

namespace app\models;

use yii\base\Model;

class PeliculasForm extends Model
{
    public $titulo;
    public $anyo;
    public $duracion;
    public $sinopsis;
    public $genero_id;

    public function rules()
    {
        return [
            [['titulo', 'genero_id'], 'required'],
            [['sinopsis'], 'trim'],
            [['anyo', 'duracion', 'genero_id'], 'number'],
            [['titulo'], 'string', 'max' => 255],
            [['anyo', 'duracion'], 'integer', 'min' => 0, 'max' => 9999],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'anyo' => 'Año',
            'sinopsis' => 'Sinopsis',
            'duracion' => 'Duración',
            'genero_id' => 'Genero',
        ];
    }
}
