<?php

class DatabaseObject {

  static protected $database;
  static protected $table_name = "";
  static protected $db_columns = [];
  public $errors = [];

  static public function set_database($database) {
    self::$database = $database;
  }

  static public function find_by_sql($sql) {
      $result = self::$database->query($sql);
      if(!$result) {
          exit("<p>Database query failed</p>");
      }

      // Turn results into objects
      $object_array = [];
      while ($record = $result->fetch(PDO::FETCH_ASSOC)) {
          $object_array[] = static::instantiate($record);
        }
      //  $result->free();
      return $object_array;
  }

  static public function find_by_id($id) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE id=" . self::$database->quote($id);
      $object_array = static::find_by_sql($sql);
      if(!empty($object_array)) {
          return array_shift($object_array);
      }   else    {
          return false;
      }
  }

  static public function find_all() {
      $sql = "SELECT * FROM " . static::$table_name . "";
      return static::find_by_sql($sql);
  }

  static public function instantiate($record) {
      $object = new static;
      foreach($record as $property => $value) {
          if(property_exists($object, $property)) {
              $object->$property = $value;
          }
      }
      return $object;
  }

  protected function validate() {
      $this->errors = [];

      // Add custom validations

      return $this->errors;
  }

  protected function create() {
      $this->validate();
      if(!empty($this->errors)) {
          return false;
      }

      // Gather attributes
      $attributes = $this->attributes();
      // Create COLUMNS string
      $attribute_keys = implode(", ", array_keys($attributes));
      // Create variable for appending ":"
      $attribute_key_bind = $attributes;
      // Append ":"
      foreach($attribute_key_bind as $key => $value) {
          $attribute_key_bind[$key] = ":" . $key;
      }
      // Create VALUES string
      $attribute_key_bind_value = implode(", ", array_values($attribute_key_bind));

      // Assemble prepare statement
      $sql = self::$database->prepare("INSERT INTO " . static::$table_name . " (" . $attribute_keys . ") VALUES (" . $attribute_key_bind_value . ")");

      // Bind each value
      foreach($attribute_key_bind as $key => $value) {
          $sql->bindValue($value, $this->$key);
      }

      $result = $sql->execute();
      if($result){
          $this->id = self::$database->lastInsertId();
      }

      return $result;
  }

  protected function update() {
      $this->validate();
      if(!empty($this->errors)) {
          return false;
      }

      $attributes = $this->attributes();
      $attribute_pairs = [];
      $attribute_pair_binds = [];
      foreach($attributes as $key => $value) {
          $attribute_pairs[] = "{$key} = :{$key}";
          $attribute_pair_binds[$key] = ":" . $key;
      }
      $attribute_pairs_str = implode(", ", array_values($attribute_pairs));

      $sql = self::$database->prepare("UPDATE " . static::$table_name . " SET " . $attribute_pairs_str . " WHERE id = :id LIMIT 1");

      $sql->bindValue(':id', $this->id);
      foreach($attribute_pair_binds as $key => $value) {
        $sql->bindValue($value, $this->$key);
      }

      $result = $sql->execute();

      return $result;
  }

  public function save() {
      // A new record will not have an ID
      if(isset($this->id)) {
          return $this->update();
      } else {
          return $this->create();
      }
  }

  public function merge_attributes($args=[]) {
      foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
              $this->$key = $value;
          }
      }
  }

  // Properties which have database columns, excluding ID
  public function attributes() {
      $attributes = [];
      foreach(static::$db_columns as $column) {
          if($column == 'id') { continue; }
          $attributes[$column] = $this->$column;
      }
      return $attributes;
  }

  public function delete() {
      $sql = self::$database->prepare("DELETE FROM " . static::$table_name . " WHERE id = :id LIMIT 1");

      $sql->bindValue(':id', $this->id);

      $result = $sql->execute();

      return $result;

      // After deleting the instance of the object will still exist
      // even though the database record does not.
      // This can be useful, as in:
      //      echo $user->first_name . " was deleted.";
      // but, for example for we cant call $user->update() after
      // calling $user->delete().
  }

}

?>