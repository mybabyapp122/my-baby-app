<?php
namespace api\modules\parent\controllers;

use common\libraries\CustomWidgets;
use yii\rest\Controller;
use Yii;

/**
 * Created by Mubashir
 * To be used for actions that are not ready on API side but ready on App side
 * September 2, 2024
 */

class MockupController extends Controller {

    public function actionIndex() {
        return 'At your service';
    }

    public function actionChildren()
    {
        $data = [
            ['id' => 1, 'title' => 'Mubashir Younus', 'short_title' => 'MY'],
            ['id' => 2, 'title' => 'Ahmed AlHarbi', 'short_title' => 'AH'],
            ['id' => 3, 'title' => 'Yawar Younus', 'short_title' => 'YY'],
            ['id' => 4, 'title' => 'Ahmed Abdullah', 'short_title' => 'AA'],
        ];
        return CustomWidgets::returnSuccess($data);
    }

    public function actionStudent()
    {
        $data = [
            'id' => 1,
            'name' => 'John Doe',
            'last_name' => 'Doughnut',
            'image_url' => 'https://picsum.photos/536/354',
            'mobile' => '056 556 4018',
            'whatsapp' => '056 556 4018',
            'health' => [
                'Covid Positive',
                'Has high fever',
                'Can die any second',
            ],
            'allergies' => [
                'Nuts',
                'Fruits',
                'Teachers',
            ],
        ];

        return CustomWidgets::returnSuccess($data);
    }

    public function actionAnnouncements()
    {
        $student = [
            'id' => 1,
            'name' => 'Abdullah Doe',
            'image_url' => 'https://picsum.photos/536/354',
        ];

        $event = [
            'students' => [$student, $student, $student],
            'title' => 'Announcement Title here',
            'message' => 'Announcement message goes here. it can be multi line',
            'date' => '2024-09-02 16:12:00'
        ];

        $data = [
            '2024-09-02 12:00:00' => [$event, $event, $event],
            '2024-09-01 12:00:00' => [$event, $event, $event],
        ];

        return CustomWidgets::returnSuccess($data);
    }

    public function actionEvents()
    {
        $student = [
            'name' => 'Abdullah Doe',
            'image_url' => 'https://picsum.photos/536/354',
        ];

        $event = [
            'students' => [$student, $student],
            'title' => 'Announcement Title here',
            'message' => 'Announcement message goes here. it can be multi line',
            'date' => '2024-09-02 16:12:00'
        ];

        $data = [
            '2024-09-02 12:00:00' => [$event, $event, $event],
            '2024-09-01 12:00:00' => [$event, $event, $event],
        ];

        return CustomWidgets::returnSuccess($data);
    }

}
