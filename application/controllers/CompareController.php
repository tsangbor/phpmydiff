<?php

class CompareController extends Zend_Controller_Action
{
    public function indexAction()
    {
      $mtime = microtime();
      $mtime = explode(" ",$mtime);
      $mtime = $mtime[1] + $mtime[0];
      $starttime = $mtime;

      $request = $this->getRequest();
      $databases = $request->getParam('database');

      $comparison = new MyDiff_Comparison;

      foreach($databases AS $database)
      {
        $database = new MyDiff_Database($database);
        $database->connect(); // remove later?

        $comparison->addDatabase($database);
      }

      $comparison->schema();
      $comparison->data();

      // Build a list of rows that have changed
      $data = array();
      $tables = array($comparison->databases[0]->getTables(), $comparison->databases[1]->getTables());
      foreach($tables[0] AS $tableName => $table)
      {
        if(!$table->hasDiffs('MyDiff_Diff_Table_New'))
        {
          $rows = array($tables[0][$tableName]->getRows(), (isset($tables[1][$tableName])? $tables[1][$tableName]->getRows() : array()));

          // remove values that don't exist in original
          if(!empty($rows[0]) && !empty($rows[1]))
          foreach($rows[1] AS &$row)
            $row->data = array_intersect_key($row->data, reset($rows[0])->data);

          $rows = array_merge($rows[0], $rows[1]);
          $data[] = array('table' => $table, 'rows' => $rows);
        }
      }

      $this->view->comparison = $comparison;
      $this->view->data = $data;

      $mtime = microtime();
      $mtime = explode(" ",$mtime);
      $mtime = $mtime[1] + $mtime[0];
      $endtime = $mtime;
      $totaltime = ($endtime - $starttime);

      $this->view->totaltime = $totaltime;
      $this->view->totalmem = memory_get_peak_usage(true);
    }
}
