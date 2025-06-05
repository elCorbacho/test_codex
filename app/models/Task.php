<?php
namespace App\Models;

class Task
{
    private $file;
    private $tasks;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../data/tasks.json';
        if (!is_dir(dirname($this->file))) {
            mkdir(dirname($this->file), 0777, true);
        }
        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([]));
        }
        $this->tasks = json_decode(file_get_contents($this->file), true);
    }

    private function save()
    {
        file_put_contents($this->file, json_encode($this->tasks, JSON_PRETTY_PRINT));
    }

    public function all()
    {
        return array_values($this->tasks);
    }

    public function find($id)
    {
        return $this->tasks[$id] ?? null;
    }

    public function create($title)
    {
        $id = count($this->tasks) ? max(array_keys($this->tasks)) + 1 : 1;
        $task = ['id' => $id, 'title' => $title];
        $this->tasks[$id] = $task;
        $this->save();
        return $task;
    }

    public function update($id, $title)
    {
        if (!isset($this->tasks[$id])) {
            return null;
        }
        $this->tasks[$id]['title'] = $title;
        $this->save();
        return $this->tasks[$id];
    }

    public function delete($id)
    {
        if (!isset($this->tasks[$id])) {
            return false;
        }
        unset($this->tasks[$id]);
        $this->save();
        return true;
    }
}
