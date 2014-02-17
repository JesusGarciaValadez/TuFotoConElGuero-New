<?php
	if (!defined('__ROOT__')) 	define('__ROOT__', dirname(dirname(__FILE__))); 
	define("EZSQL_VERSION","1.01");
	define("OBJECT","OBJECT",true);
	define("ARRAY_A","ARRAY_A",true);
	define("ARRAY_N","ARRAY_N",true);
	
	require_once (__ROOT__.'/core/config.php');
		
	class MySQL
    {
      public $error=false;
      public $strError="";
      public $dbh;

		function MySQL()
		{
			//echo "Mysql";
			$c = new Config();
			
			$this->dbh = @mysql_connect($c->DB_HOST, $c->DB_USER, $c->DB_PASS);			
			if (!$this->dbh)
			{
				$this->error=true;//$this->print_error("<ol><b>Error al establcer conexi&oacute;n con la base de datos</b><li>Verifique que el nombre de usuario y contrase&ntilde;a</li><li>Verifique el nombre del hostname</li><li>Verifique el nombre de la base de datos</li><li>Finalmente, verifique que el servidor de base de datos est&eacute; corriendo</li></ol>");
			}
			$this->select($c->DB_NAME);
		}

		function select($db)
		{
			if ( !@mysql_select_db($db,$this->dbh))
			{
				$this->error=true; //$this->print_error("<ol><b>Error al seleccionar la base datos <u>$db</u>!</b><li>Verifique que la base de datos existe</li><li>Verifique que existe conexi&oacute;n con la base de datos</li></ol>");
			}
		}

		function print_error($str = "")
		{
			if ( !$str ) $str = mysql_error();
			print "<blockquote><font face=arial size=2 color=ff0000>";
			print "<b>SQL/DB Error --</b> ";
			print "[<font color=000077>$str</font>]";
			print "</font></blockquote>";
			$this->strError= mysql_error();
		}

		function query($query, $output = OBJECT)
		{
			//$query = mysql_real_escape_string($query);
            //$query = stripslashes($query);
            
            $this->func_call = "\$db->query(\"$query\", $output)";

			$this->last_result = null;
			$this->col_info = null;
			$this->last_query = $query;
            
			$this->result = mysql_query($query,$this->dbh);

			if ( mysql_error() )
			{
				$this->print_error();
				$this->error=true;
			}
			else
			{
				if ( $this->result )
				{
					$i=0;
					while ($i < @mysql_num_fields($this->result))
					{
						$this->col_info[$i] = @mysql_fetch_field($this->result);
						$i++;
					}
					$i=0;
					while ( $row = @mysql_fetch_object($this->result) )
					{
						$this->last_result[$i] = $row;
						$i++;
					}
					@mysql_free_result($this->result);

					if ( $i ) return true;
					else return false;
				}
			}
		}

		function get_var($query=null,$x=0,$y=0)
		{
			$values=0;
			$this->func_call = "\$db->get_var(\"$query\",$x,$y)";

			if ( $query ) $this->query($query);
			if ( $this->last_result[$y] ) $values = array_values(get_object_vars($this->last_result[$y]));
			return $values[$x]?$values[$x]:null;
		}

		function get_row($query=null,$y=0,$output=OBJECT)
		{
			$this->func_call = "\$db->get_row(\"$query\",$y,$output)";
			if ( $query ) $this->query($query);
			if ( $output == OBJECT ) return $this->last_result[$y]?$this->last_result[$y]:null;
			elseif ( $output == ARRAY_A ) return $this->last_result[$y]?get_object_vars($this->last_result[$y]):null;
			elseif ( $output == ARRAY_N ) return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
			else $this->print_error(" \$db->get_row(string query,int offset,output type) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N ");
		}

		function get_col($query=null,$x=0)
		{
			if ( $query ) $this->query($query);
			for ( $i=0; $i < count($this->last_result); $i++ )
			{
				$new_array[$i] = $this->get_var(null,$x,$i);
			}

			return $new_array;
		}

		function get_results($query=null, $output = OBJECT)
		{
			$this->func_call = "\$db->get_results(\"$query\", $output)";

			if ( $query ) $this->query($query);
			if ( $output == OBJECT ) return $this->last_result;
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->last_result )
				{
					$i=0;
					foreach( $this->last_result as $row )
					{
						$new_array[$i] = get_object_vars($row);
						if ( $output == ARRAY_N ) $new_array[$i] = array_values($new_array[$i]);
						$i++;
					}
					return $new_array;
				}
				else return null;
			}
		}

		function get_col_info($info_type="name",$col_offset=-1)
		{
			if ( $this->col_info )
			{
				if ( $col_offset == -1 )
				{
					$i=0;
					foreach($this->col_info as $col )
					{
						$new_array[$i] = $col->{$info_type};
						$i++;
					}
					return $new_array;
				}
				else return $this->col_info[$col_offset]->{$info_type};
			}
		}

		function vardump($mixed)
		{
			echo "<blockquote><font color=000090>";
			echo "<pre><font face=arial>";

			if ( ! $this->vardump_called )
			{
				echo "<font color=800080><b>ezSQL</b> (v".EZSQL_VERSION.") <b>Variable Dump..</b></font>\n\n";
			}

			print_r($mixed);
			echo "\n\n<b>Last Query:</b> ".($this->last_query?$this->last_query:"NULL")."\n";
			echo "<b>Last Function Call:</b> " . ($this->func_call?$this->func_call:"None")."\n";
			echo "<b>Last Rows Returned:</b> ".count($this->last_result)."\n";
			echo "</font></pre></font></blockquote>";
			echo "\n<hr size=1 noshade color=dddddd>";

			$this->vardump_called = true;
		}

		function dumpvars($mixed)
		{
			$this->vardump($mixed);
		}

		function debug()
		{
			echo "<blockquote>";

			if ( ! $this->debug_called )
			{
				echo "<font color=800080 face=arial size=2><b>ezSQL</b> (v".EZSQL_VERSION.") <b>Debug..</b></font><p>\n";
			}
			echo "<font face=arial size=2 color=000099><b>Query --</b> ";
			echo "[<font color=000000><b>$this->last_query</b></font>]</font><p>";

			echo "<font face=arial size=2 color=000099><b>Query Result..</b></font>";
			echo "<blockquote>";

			if ( $this->col_info )
			{
				echo "<table cellpadding=5 cellspacing=1 bgcolor=555555>";
				echo "<tr bgcolor=eeeeee><td nowrap valign=bottom><font color=555599 face=arial size=2><b>(row)</b></font></td>";

				for ( $i=0; $i < count($this->col_info); $i++ )
				{
					echo "<td nowrap align=left valign=top><font size=1 color=555599 face=arial>{$this->col_info[$i]->type} {$this->col_info[$i]->max_length}<br><font size=2><b>{$this->col_info[$i]->name}</b></font></td>";
				}
				echo "</tr>";

				if ( $this->last_result )
				{
					$i=0;
					foreach ( $this->get_results(null,ARRAY_N) as $one_row )
					{
						$i++;
						echo "<tr bgcolor=ffffff><td bgcolor=eeeeee nowrap align=middle><font size=2 color=555599 face=arial>$i</font></td>";

						foreach ( $one_row as $item )
						{
							echo "<td nowrap><font face=arial size=2>$item</font></td>";
						}
						echo "</tr>";
					}
				}
				else
				{
					echo "<tr bgcolor=ffffff><td colspan=".(count($this->col_info)+1)."><font face=arial size=2>No Results</font></td></tr>";
				}
				echo "</table>";
			}
			else
			{
				echo "<font face=arial size=2>No Results</font>";
			}

			echo "</blockquote></blockquote><hr noshade color=dddddd size=1>";
			$this->debug_called = true;
		}
	}
?>
