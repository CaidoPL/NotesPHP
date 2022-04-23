<?php

declare(strict_types=1);

namespace App\Controllers;

class NoteController extends AbstractController
{
    private const PAGE_SIZE = 10;

    public function createAction(): void
    {
        if ($this->request->hasPost()) {
            $created = true;
            $this->noteModel->create([
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ]);
            $this->redirect('/Notes/', ['before' => 'created']);
        }
        $this->View->render('create') ?? [];
    }

    public function listAction(): void
    {
        $pageSize = (int) $this->request->getParam('pagesize', self::PAGE_SIZE);
        $pageNumber = (int) $this->request->getParam('page', 1);

        $sortBy = $this->request->getParam('sortby', 'created');
        $sortOrder = $this->request->getParam('sortorder', 'asc');
        $search = $this->request->getParam('search');


        if (!in_array($pageSize, [1, 5, 10, 20, 25])) {
            $pageSize = self::PAGE_SIZE;
        }

        if ($search) {
            $search = htmlentities($this->request->getParam('search'));
            $note = $this->noteModel->search($search, $pageNumber, $pageSize, $sortBy, $sortOrder);
            $noteCount = $this->noteModel->searchCount($search);
        } else {
            $note = $this->noteModel->list($pageNumber, $pageSize, $sortBy, $sortOrder);
            $noteCount = $this->noteModel->count();
        }


        $this->View->render(
            'list',
            [
                'page' => [
                    'number' => $pageNumber,
                    'size' => $pageSize,
                    'pages' => (int) ceil($noteCount / $pageSize)
                ],
                'search' => $search,
                'sort' => [
                    'by' => $sortBy,
                    'order' => $sortOrder
                ],
                'notes' => $note,
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error')
            ]
        ) ?? [];
    }

    public function showAction(): void
    {
        $this->View->render('show', ['note' => $this->getNote()]) ?? [];
    }

    public function editAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $this->noteModel->edit(
                $noteId,
                [
                    'title' => $this->request->postParam('title'),
                    'description' => $this->request->postParam('description')
                ]
            );
            $this->redirect('/Notes/', ['before' => 'edited']);
        }

        $this->View->render('edit', ['note' => $this->getNote()]) ?? [];
    }

    public function deleteAction(): void
    {
        if ($this->request->isPost()) {
            $id = (int) $this->request->postParam('id');
            $this->noteModel->delete($id);
            $this->redirect('/Notes/', ['before' => 'deleted']);
        }

        $this->View->render('delete', ['note' => $this->getNote()]) ?? [];
    }

    private function getNote(): array
    {
        $noteId = (int) $this->request->getParam('id');

        if (!$noteId) {
            $this->redirect('/Notes/', ['error' => 'missingNoteId']);
        }
        $note = $this->noteModel->get($noteId);
        return $note;
    }
}
