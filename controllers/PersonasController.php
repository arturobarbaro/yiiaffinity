<?php

namespace app\controllers;

use app\models\Peliculas;
use app\models\Personas;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PersonasController extends Controller
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
        $filas = Personas::find()
            ->all();
        return $this->render('index', [
            'personas' => $filas,
        ]);
    }
    public function actionCreate()
    {
        $persona = new Personas();
        if ($persona->load(Yii::$app->request->post()) && $persona->save()) {
            Yii::$app->session->setFlash('success', 'Fila insertada correctamente.');
            return $this->redirect(['personas/index']);
        }
        return $this->render('create', [
            'persona' => $persona,
        ]);
    }
    public function actionVer($id)
    {
        return $this->render('ver', [
            'persona' => $this->buscarGenero($id),
            'peliculas' => Peliculas::findAll(['persona_id' => $id]),
        ]);
    }
    /**
     * Modifica un género.
     * @param  int             $id El id del género a modificar
     * @return string|Response     El formulario de modificación o una redirección
     */
    public function actionUpdate($id)
    {
        $persona = $this->buscarPersona($id);
        if ($persona->load(Yii::$app->request->post()) && $persona->save()) {
            Yii::$app->session->setFlash('success', 'Fila modificada correctamente.');
            return $this->redirect(['personas/index']);
        }
        return $this->render('update', [
            'persona' => $persona,
        ]);
    }
    /**
     * Borra un género.
     * @param  int      $id El id del género a borrar
     * @return Response     Una redirección
     */
    public function actionDelete($id)
    {
        $this->buscarPersona($id)->delete();
        return $this->redirect(['personas/index']);
    }
    /**
     * Localiza un género por su id.
     * @param  int                   $id El id del género
     * @return array                     El género si existe
     * @throws NotFoundHttpException     Si el género no existe
     */
    private function buscarPersona($id)
    {
        $persona = Personas::findOne($id);
        if ($persona === null) {
            throw new NotFoundHttpException('El género no existe.');
        }
        return $persona;
    }
}
