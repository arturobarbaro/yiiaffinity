<?php

namespace app\controllers;

use app\models\Papeles;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PapelesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
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
     * Listado de géneros.
     * @return string La vista del listado de géneros
     */
    public function actionIndex()
    {
        $filas = Papeles::find()
            ->all();
        return $this->render('index', [
            'papeles' => $filas,
        ]);
    }
    public function actionCreate()
    {
        $papel = new Papeles();
        if ($papel->load(Yii::$app->request->post()) && $papel->save()) {
            Yii::$app->session->setFlash('success', 'Fila insertada correctamente.');
            return $this->redirect(['papeles/index']);
        }
        return $this->render('create', [
            'papel' => $papel,
        ]);
    }
    // public function actionVer($id)
    // {
    //     return $this->render('ver', [
    //         'papel' => $this->buscarGenero($id),
    //         'peliculas' => Peliculas::findAll(['papel_id' => $id]),
    //     ]);
    // }
    /**
     * Modifica un género.
     * @param  int             $id El id del género a modificar
     * @return string|Response     El formulario de modificación o una redirección
     */
    public function actionUpdate($id)
    {
        $papel = $this->buscarPapel($id);
        if ($papel->load(Yii::$app->request->post()) && $papel->save()) {
            Yii::$app->session->setFlash('success', 'Fila modificada correctamente.');
            return $this->redirect(['papeles/index']);
        }
        return $this->render('update', [
            'papel' => $papel,
        ]);
    }
    /**
     * Borra un género.
     * @param  int      $id El id del género a borrar
     * @return Response     Una redirección
     */
    public function actionDelete($id)
    {
        $this->buscarPapel($id)->delete();
        return $this->redirect(['papeles/index']);
    }
    /**
     * Localiza un género por su id.
     * @param  int                   $id El id del género
     * @return array                     El género si existe
     * @throws NotFoundHttpException     Si el género no existe
     */
    private function buscarPapel($id)
    {
        $papel = Papeles::findOne($id);
        if ($papel === null) {
            throw new NotFoundHttpException('El género no existe.');
        }
        return $papel;
    }
}
