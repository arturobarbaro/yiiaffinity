<?php

namespace app\controllers;

use app\models\GenerosForm;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Definición del controlador generos.
 */
class GenerosController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'acces' => [
                'class' => AccessControl::class,
                'only' => ['update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    /**
     * [actionIndex description].
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'genero',
            ],
        ]);
        $count = \Yii::$app->db
            ->createCommand('SELECT count(*) FROM generos')->queryScalar();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $count,
        ]);


        $filas = \Yii::$app->db
                ->createCommand('SELECT g.*, count(p.id) as num
                                   FROM generos g
                              LEFT JOIN peliculas p
                                     ON p.genero_id=g.id
                               GROUP BY g.id
                               ORDER BY genero
                                  LIMIT :limit
                                 OFFSET :offset', [
                        ':limit' => $pagination->limit,
                        'offset' => $pagination->offset,
                                            ])->queryAll();
        return $this->render('index', [
            'filas' => $filas,
            'pagination' => $pagination,
        ]);
    }
    /**
     * Crea un género.
     * @param  int             $id Identificador del género a crear
     * @return string|Response     El formulario de creación o una redirección
     */
    public function actionCreate()
    {
        $generosForm = new GenerosForm();

        if ($generosForm->load(Yii::$app->request->post()) && $generosForm->validate()) {
            Yii::$app->db->createCommand()
                ->insert('generos', $generosForm->attributes)
                ->execute();
            Yii::$app->session->setFlash('success', 'Genero insertado correctamente');
            return $this->redirect(['generos/index']);
        }
        return $this->render('create', [
            'generosForm' => $generosForm,
        ]);
    }

    /**
     * Modifica un género.
     * @param  int             $id Identificador del género a modificar
     * @return string|Response     El formulario de modificación o una redirección
     */
    public function actionUpdate($id)
    {
        $generosForm = new GenerosForm(['attributes' => $this->buscarGenero($id)]);

        if ($generosForm->load(Yii::$app->request->post()) && $generosForm->validate()) {
            Yii::$app->db->createCommand()
                ->update('generos', $generosForm->attributes, ['id' => $id])
                ->execute();
            Yii::$app->session->setFlash('success', 'Genero modificado correctamente');
            return $this->redirect(['generos/index']);
        }

        return $this->render('update', [
            'generosForm' => $generosForm,
            'listaGeneros' => $this->listaGeneros(),
        ]);
    }

    /**
     * Borra un género.
     * @param  int       $id Identificador del genero a borrar
     * @return Response      Una redireccion
     */
    public function actionDelete($id)
    {
        $peliculas = Yii::$app->db->createCommand('SELECT id  --count(*)
                                                     FROM peliculas
                                                    WHERE genero_id = :id
                                                    LIMIT 1', ['id' => $id])
                                                    ->queryOne();//queryScalar

        if (empty($peliculas)) {
            Yii::$app->db->createCommand()->delete('generos', ['id' => $id])->execute();
            Yii::$app->session->setFlash('success', 'Genero borrado correctamente');
        } else {
            Yii::$app->session->setFlash('error', 'No se puede borrar un género asociado a una película');
        }

        return $this->redirect(['generos/index']);
    }

    private function listaGeneros()
    {
        $generos = Yii::$app->db->createCommand('SELECT * FROM generos')->queryAll();
        $listaGeneros = [];
        foreach ($generos as $genero) {
            $listaGeneros[$genero['id']] = $genero['genero'];
        }
        return $listaGeneros;
    }

    /**
     * Localiza un género por su id.
     * @param  int                  $id El identificador
     * @return array                    El género si existe
     * @throws NotFoundHttpException     Si el género no existe
     */
    private function buscarGenero($id)
    {
        $fila = Yii::$app->db
            ->createCommand('SELECT *
                               FROM generos
                              WHERE id = :id', [':id' => $id])->queryOne();
        if ($fila === false) {
            throw new NotFoundHttpException('Ese género no existe.');
        }
        return $fila;
    }
}
