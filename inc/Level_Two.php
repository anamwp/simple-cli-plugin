<?php 
namespace Anam\SimpleCLIPlugin;

class Level_Two{
	public function export_csv_test(){
        $list = array (
            array("Eric", "Griffin" ,"Oslo", "Norway"),
            array("Glenn", "Quagmire", "Oslo", "Norway")
        );
        
        $file = fopen("contacts.csv","w");
        
        foreach ($list as $line) {
            fputcsv($file, $line);
        }
        
        fclose($file);

        \WP_CLI::success( sprintf( 'file created %s', 'contacts.csv' ) );
        // WP_CLI::success( sprintf( "File created: %s", $filename ) );

  }
    
}
