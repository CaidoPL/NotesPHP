<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Request;
use App\View;
use App\Model\NoteModel;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

abstract class AbstractController
{
    protected const DEFAULT_ACTION = 'list';
    private static array $configuration = [];
    protected Request $request;
    protected View $view;
    protected NoteModel $noteModel;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {

        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException('Configuration Error');
        }
        $this->noteModel = new NoteModel(self::$configuration['db']);
        $this->request = $request;
        $this->View = new View();
    }

    final public function run(): void
    {
        try {
            $action = $this->action() . 'Action';
            if (!method_exists($this, $action)) {
                $action = self::DEFAULT_ACTION . 'Action';
            }
            $this->$action();
        } catch (\Throwable $e) {
            $this->View->render('error', ['message' => $e->getMessage()]);
        } catch (NotFoundException $e) {
            $this->redirect('/Notes/', ['error' => 'noteNotFound']);
        }
    }

    final protected function redirect(string $to, array $params): void
    {
        $queryParams = [];
        if (count($params)) {
            foreach ($params as $key => $value) {
                $queryParams[] = urlencode($key) . '=' . urlencode($value);
            }
            $queryParams = implode('&', $queryParams);
        }
        header("Location: $to?$queryParams");
        exit;
    }

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}
