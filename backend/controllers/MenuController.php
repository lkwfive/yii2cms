<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Menu;
use common\models\MenuSearch;
use backend\models\MenuForm;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends CommonController
{

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTree()
    {
        return $this->render('tree');
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "创建成功");
            return $this->redirect(['tree']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new MenuForm();
        $menu = $this->findModel($id);
        $model->laodMenu($menu);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "更新成功");
            return $this->redirect(['update', 'id' => $model->menu->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['tree']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            $model->backendData();
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMove($id,$updown)
    {
        $model=$this->findModel($id);
        if($updown=="down") {
            $sibling=$model->next()->one();
            if (isset($sibling)) {
                if($model->moveAfter($sibling))
                    Yii::$app->session->setFlash('success', "移动成功！");
                return $this->redirect(['tree']);
            }
            return $this->redirect(['tree']);
        }
        if($updown=="up"){
            $sibling=$model->prev()->one();
            if (isset($sibling)) {
                if($model->moveBefore($sibling))
                    Yii::app()->user->setFlash('success', "移动成功！");
                return $this->redirect(['tree']);
            }
            return $this->redirect(['tree']);
        }
    }
}
