<?php
/**
 * Created by PhpStorm.
 * User: nitikorn
 * Date: 3/8/19
 * Time: 12:35 PM
 */

main::start("example.csv");

class main {

    static public function start($filename) {

        $records = csv::getRecords($filename);
        $table = html::generateTable($records);

    }

}

class html {

    public static function generateTable($records) {

        $count = 0;
        print("<html>");
        print("<head>
<style type=\"text/css\">
    
    tr.header {background-color: Lightblue; height: 24px}
    tr.even {background-color: Lightgreen; height: 24px}
    tr.odd {background-color: Pink; height: 24px}
 
    td:hover {background-color: Red;}
</style>
</head>");
            print("<body><center>");
        print("<table border='1'>");
        foreach ($records as $record) {


            if ($count == 0) {
                print("<tr class = 'header'>");
                $array = $record->returnArray();
                $fields = array_keys($array);
                $values = array_values($array);
                foreach ($fields as $columnName)
                    {
                        print("<th>");
                        print_r($columnName);
                        print("</th>");

                    }
                print("</tr>");

            }

            {

                print("<tr class='");print($count%2==0?"even":"odd");print("'>");
                $array = $record->returnArray();
                $values = array_values($array);
                foreach ($values as $columnValue)
                {
                    print("<td>");
                    print_r($columnValue);
                    print("</td>");
                }
                print("</tr>");
            }
            $count++;

        }
        print("</table>");
        print("</center></body></html>");
    }
}
class csv {

    static public function getRecords($filename) {


        $file = fopen($filename,"r");

        $fieldNames = array();

        $count = 0;

        while(! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }

        fclose($file);
        return $records;

    }

}

class record {

    public function __construct(Array $fieldNames = null, $values = null)
    {

        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }

    }

    public function returnArray() {
        $array = (array) $this;

        return $array;
    }

    public function createProperty ($name = 'first', $value = 'keith') {

        $this->{$name} = $value;

    }
}

class recordFactory {

    public static function create(Array $fieldNames = null, Array $values = null) {

        $record = new record($fieldNames, $values);

        return $record;

    }

}
