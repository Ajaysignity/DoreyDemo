<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Solution_model extends MY_Model {
    public function __construct(){
        parent::__construct();
		$this->draggedSolutionClass= 'connectedSortableSolution_drag';
		$this->droppedSolutionClass= 'droppedSolutionArea';
    }
    public function getmysolutions($data = array(), $Parentfolderid = 'NULL',$isarchived = 0) {
		$TotalRows = 0;
		$aColumns = array('Solution','DateTime_Last_Accessed','idusersolutions','idusersolutions');
		$limit = ""; $sWhere = "";$offset = '';
		if ( isset( $data['start'] ) && $data['length'] != '-1' ) {
			$limit = $data['start']; $offset = $data['length'];
		}
		$sOrder = ""; $sWhere = "";$OrderPattern='desc';
		if ( isset($data['search']['value']) && $data['search']['value'] != "" ) {
			$sWhere = "  (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				$sWhere .= $aColumns[$i]." LIKE '%". $data['search']['value'] ."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ") ";
		}
		if ( isset( $data['order'] ) ) {
			for ( $i=0 ; $i<intval( $data['order'] ) ; $i++ ){
				$sOrder .= $aColumns[ intval( $data['order'][$i]['column'] ) ];
				$OrderPattern = $data['order'][$i]['dir'];
			}
		}
		$returnRow = array();
		$this->db->select('count(*) as total')->from("{$this->userstable} a")->join("{$this->solutionstable} b","a.id = b.User")->where('a.organisation', $this->organisation )->where('b.User', $this->userid )->where('b.isarchived', $isarchived)->where('b.Type', 'CashflowModel');
		if( !empty($sWhere) ){
			$this->db->where($sWhere);
		}
		if( !empty($Parentfolderid) && $Parentfolderid != 'null') {
			$this->db->where("ParentFolderID",$Parentfolderid);
		} else{
			$this->db->where("(ParentFolderID IS NULL OR ParentFolderID = 0 )");
		}
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$info = $CountSQL->row();
			$TotalRows = $info->total;			
		}
		
		$this->db->select('b.Type,b.DateTime_Last_Accessed,b.idusersolutions,b.Solution,b.UniqueFolderID,b.ParentFolderID')->from("{$this->userstable} a")->join("{$this->solutionstable} b","a.id = b.User")->where('a.organisation', $this->organisation )->where('b.User', $this->userid )->where('b.isarchived', $isarchived)->where('b.Type', 'CashflowModel');
		if( !empty($sWhere) ){
			$this->db->where($sWhere);
		}
		if( !empty($Parentfolderid) && $Parentfolderid != 'null') {
			$this->db->where("ParentFolderID",$Parentfolderid);
		} else{
			$this->db->where("(ParentFolderID IS NULL OR ParentFolderID = 0 )");
		}
		if( !empty($sOrder) && !empty($OrderPattern) ){
			$this->db->order_by($sOrder,$OrderPattern);
		} else {
			$this->db->order_by("idusersolutions","desc");
		}
		$this->db->limit($offset,$limit);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ) {
			$lists = $query->result();
			foreach( $lists as $list  ) :
				$encsolnid = encryptKey($list->idusersolutions);
				$returnRow[] = array(
					'<span class="solutionid'.$encsolnid.'">'.DRAGHANDLERICON.'</span><span href="" onClick="window.location.href=\''.website_url($this->controller.'/cashflow?tokenkey='.$encsolnid).'\'" uk-tooltip="Click to view solutions" style="cursor: pointer;">'.$list->Solution.'</span>',
					(!empty($list->DateTime_Last_Accessed) ? defaultdate($list->DateTime_Last_Accessed) : 'NA'),
					$this->SolutionActionBtns($this->userid,$list->idusersolutions,$list->Type,$list->UniqueFolderID,$list->ParentFolderID),
					$list->idusersolutions
				);
			endforeach;
		}
		return array(
			'TotalRows' => $TotalRows,
			'returndata' => $returnRow,
		);
	}
    protected function SolutionActionBtns( $userid,$idusersolutions, $ModelType,$UniqueFolderID,$ParentFolderID, $nextboxnumer = NULL) {
		$labelName = ( $ModelType == 'CashflowModel' ? 'solution' : 'folder');
		$encidsoln = encryptKey($idusersolutions);
		$OpenClassID = '';$frompage = NULL;
		$output = '';
		$output .= '<span href="javascript:void(0);" uk-icon="pencil" class="uk-margin-small-right"></span>
		<div uk-dropdown class="EditdropdownBox">
			<ul class="uk-nav uk-dropdown-nav">';
			if($ModelType == 'Folder') {
				$output .= '<li><a onclick="solution_view_modal(\''.$this->controller.'/addfoldersolution\',this)" href="javascript:void(0);" data-autoid="'.$encidsoln.'"  data-FolderUniQIDS="'.$UniqueFolderID.'"  data-FolderPrntQIDS="'.$ParentFolderID.'" data-nextboxnumer="'.$nextboxnumer.'" >Create new solution</a></li>';
			}
			$output .= '<li><a href="javascript:void(0);" onclick="solution_view_modal(\''.$this->controller.'/renamesolutionfolder\',this)" data-autoid="'.$encidsoln.'"  data-nextboxnumer="'.$nextboxnumer.'" data-FolderPrntQIDS="'.$ParentFolderID.'">Rename '.$labelName.'</a></li>';
				if($ModelType == 'Folder') {
					$output .= '<li><a onclick="solution_view_modal(\''.$this->controller.'/addsubfolder\',this)" href="javascript:void(0);" data-autoid="'.$encidsoln.'"  data-FolderUniQIDS="'.$UniqueFolderID.'"  data-FolderPrntQIDS="'.$ParentFolderID.'" data-nextboxnumer="'.$nextboxnumer.'" >Add sub '.$labelName.'</a></li>';
				}
				$output .= '<li><a onclick="Final_DuplicateSolutions(this);" href="javascript:void(0);" data-SolRow="'.$encidsoln.'" data-modeltype="'.$ModelType.'" data-FolderUniQIDS="'.$UniqueFolderID.'" data-FolderPrntQIDS="'.$ParentFolderID.'" data-userid="'.encryptKey($userid).'"  data-nextboxnumer="'.$nextboxnumer.'">Duplicate '.$labelName.'</a></li>
			</ul>
		</div>
		<a href="javascript:void(0);" uk-icon="icon: trash" onclick="Final_removeFolderSolutions(this)" data-SolRow="'.$encidsoln.'" data-frompage="'.$frompage.'" data-modeltype="'.encryptKey($ModelType).'" data-FolderUniQIDS="'.encryptKey(!empty($UniqueFolderID) ? $UniqueFolderID : 0 ).'"  data-isarchived="'.encryptKey('archive').' "  data-nextboxnumer="'.$nextboxnumer.'"  data-FolderPrntQIDS="'.$ParentFolderID.'"></a>';
		return $output;
	}
    public function getallfolders( $nextboxnumer,$isarchived =0 ) {
		$lists = array();
		$this->db->select('b.Type,b.DateTime_Last_Accessed,b.idusersolutions,b.Solution,b.UniqueFolderID,b.ParentFolderID')->from("{$this->userstable} a")->join("{$this->solutionstable} b","a.id = b.User")->where('a.organisation', $this->organisation )->where('b.User', $this->userid )->where("(ParentFolderID IS NULL OR ParentFolderID = 0 )")->where('b.isarchived', $isarchived)->where('b.Type', 'Folder')->limit(20);
		$this->db->order_by("idusersolutions","ASC");
		$query = $this->db->get();
		$this->db->last_query();
		$iTems = '';
		if($query -> num_rows() >0 ) {
			$lists = $query->result();
			foreach($lists as $list ):
				$iTems .= '
					<li class="uk-flex uk-margin-small-bottom '.$this->droppedSolutionClass.'" data-solnRowId="'.$list->idusersolutions.'" data-drcurrentbox="'.$nextboxnumer.'" data-Parentfolderid="'.$list->ParentFolderID.'">
					<span class="uk-drag solutionid'.encryptKey($list->idusersolutions).'">'.DRAGHANDLERICON.'</span>	
					<span class="uk-margin-small-right uk-icon" uk-icon="folder"></span> 
						<a class="folderlistboxsection_lia" href="javascript:void(0)" data-Parentfolderid="'.$list->UniqueFolderID.'" data-solnid="'.$list->idusersolutions.'">'.$list->Solution.'<span class="uk-icon" uk-icon="chevron-right"></span></a>
						'.$this->SolutionActionBtns($this->userid,$list->idusersolutions,$list->Type,$list->UniqueFolderID,$list->ParentFolderID,1).'
					</li>
				';
			endforeach;
		}
		return $iTems;
	}
    public function _SearchedSolutions($data = array(), $searchkey = NULL ) {
		$TotalRows = 0;
		$aColumns = array('Solution','DateTime_Last_Accessed','idusersolutions','idusersolutions');
		$limit = ""; $sWhere = "";$offset = '';
		if ( isset( $data['start'] ) && $data['length'] != '-1' ) {
			$limit = $data['start']; $offset = $data['length'];
		}
		$sOrder = ""; $sWhere = "";$OrderPattern='desc';
		if ( isset($data['search']['value']) && $data['search']['value'] != "" ) {
			$sWhere = "  (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				$sWhere .= $aColumns[$i]." LIKE '%". $data['search']['value'] ."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ") ";
		}
		if ( isset( $data['order'] ) ) {
			for ( $i=0 ; $i<intval( $data['order'] ) ; $i++ ){
				$sOrder .= $aColumns[ intval( $data['order'][$i]['column'] ) ];
				$OrderPattern = $data['order'][$i]['dir'];
			}
		}
		$returnRow = array();
		$this->db->select('count(*) as total')->from("{$this->userstable} a")->join("{$this->solutionstable} b","a.id = b.User")->where('a.organisation', $this->organisation )->where('b.User', $this->userid )->where('b.isarchived', 0)->where('b.Type', 'CashflowModel');
		if( !empty($sWhere) ){
			$this->db->where($sWhere);
		}
        if (!empty($searchkey)) {
			$this->db->like("Solution", $searchkey);
		}
		$CountSQL = $this->db->get();
		$this->db->last_query();
		if($CountSQL->num_rows() >0 ){
			$info = $CountSQL->row();
			$TotalRows = $info->total;			
		}
		
		$this->db->select('b.Type,b.isarchived,b.DateTime_Last_Accessed,b.idusersolutions,b.Solution,b.UniqueFolderID,b.ParentFolderID')->from("{$this->userstable} a")->join("{$this->solutionstable} b","a.id = b.User")->where('a.organisation', $this->organisation )->where('b.User', $this->userid )->where('b.Type', 'CashflowModel');
		if( !empty($sWhere) ){
			$this->db->where($sWhere);
		}
        if (!empty($searchkey)) {
			$this->db->like("Solution", $searchkey);
		}
		$this->db->order_by("Solution","ASC");
		$this->db->limit($offset,$limit);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ) {
			$lists = $query->result();
			foreach( $lists as $list  ) :
                $locations = $this->getlocationpath($list->isarchived,$list->ParentFolderID);
				$returnRow[] = array(
					'<span class="uk-flex uk-flex-between_"><span class="uk-margin-small-right uk-icon" uk-icon="folder"></span>  <span class="black_text"><a href="#">'.$list->Solution.'</a> <br> <small><b>Date Modified: </b>'.defaultdate($list->DateTime_Last_Accessed).'</small></span></span>',
					'<span class="black_text">'.$locations.'</span>'
				);
			endforeach;
		}
		return array(
			'TotalRows' => $TotalRows,
			'returndata' => $returnRow,
		);
	}
    public function getlocationpath($isarchived,$ParentFolderID) {
        $locations = '';
        if($isarchived == 0 ) {
            $locations .= '<a href="'.website_url('solutions').'">My Solution</a>';
        } else if($isarchived == 1 ) {
            $locations .= '<a href="'.website_url('solutions/wastebasket').'">Waste Basket</a>';
        }
        if( !empty($ParentFolderID) ) {
            $firstRow = $this->db->select('Solution,UniqueFolderID,ParentFolderID')->from("{$this->solutionstable} ")->where('User', $this->userid )->where('isarchived', 0)->where("UniqueFolderID",$ParentFolderID)->get();
            $this->db->last_query();
            if($firstRow -> num_rows() >0 ) {
                $firstRowData = $firstRow->row();
                $locations .= "/".$firstRowData->Solution;
                if( !empty($firstRowData->ParentFolderID) || $firstRowData->ParentFolderID >0 ) {
                    $secondRow = $this->db->select('Solution,UniqueFolderID,ParentFolderID')->from("{$this->solutionstable} ")->where('User', $this->userid )->where('isarchived', 0)->where("UniqueFolderID",$firstRowData->ParentFolderID)->get();
                    if($secondRow -> num_rows() >0 ) {
                        $secondRowData = $secondRow->row();
                        $locations .= "/".$secondRowData->Solution;
                        if( !empty($secondRowData->ParentFolderID) || $secondRowData->ParentFolderID >0 ) {
                            $ThirdRow = $this->db->select('Solution,UniqueFolderID,ParentFolderID')->from("{$this->solutionstable} ")->where('User', $this->userid )->where('isarchived', 0)->where("UniqueFolderID",$secondRowData->ParentFolderID)->get();
                            if($ThirdRow -> num_rows() >0 ) {
                                $ThirdRowData = $ThirdRow->row();
                                $locations .= "/".$ThirdRowData->Solution;
                            }
                        }
                    }
                 }
            }
        }
        return $locations;
    }
    public function UpdateSolutions($userid,$idusersolutions,$parameters = array(),$otherparams=NULL) {
		if( !empty($otherparams) ){
			$this->db->where("( ParentFolderID IN (".$otherparams['ParentFolderID'].") or UniqueFolderID = ".$otherparams['UniqueFolderID']." )");
		} else {
			$this->db->where('idusersolutions', $idusersolutions);
		}
		$this->db->where('User', $userid);
		$this->db->update("{$this->solutionstable}",$parameters);
		$this->db->last_query();
		if( !empty($otherparams) ){
			$this->db->where('Type', 'Folder');
			$this->db->where("( ParentFolderID IN (".$otherparams['ParentFolderID'].") or UniqueFolderID = ".$otherparams['UniqueFolderID']." ) ");
			$this->db->where('idusersolutions', $idusersolutions);
			$this->db->delete("{$this->solutionstable}");
			$this->db->last_query();
		}
		return true;	
	}
    public function SaveSolutionFolder($parameters = array()){
		$this->db->insert("{$this->solutionstable}",$parameters);
		$this->db->last_query();
		return $this->db->insert_id();
	}
    public function NextUniqueFolderID($fromtype = NULL) {
		$this->db->select("MAX(UniqueFolderID) AS MaxFolderID");
		$this->db->from("{$this->solutionstable}");
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$return = $query->row();
			if( !empty($fromtype) ) {
				return $return->MaxFolderID;
			} else {
				return ($return->MaxFolderID+1);
			}
		}
	}
    public function getsolutionInfo($userid, $idusersolutions) {
		$return = array();
		$this->db->select("*");
		$this->db->from("{$this->solutionstable}");
		$this->db->where('User', $userid);
		$this->db->where("idusersolutions",$idusersolutions);
		$query = $this->db->get();
		$this->db->last_query();
		if($query -> num_rows() >0 ){
			$return = $query->row();
			
		}
		return $return;
	}
    public function getsubfolderslist($nextboxnumer,  $solnid, $Parentfolderid, $isarchived = 0 ) {
		$lists = array();
		$this->db->select('b.Type,b.DateTime_Last_Accessed,b.idusersolutions,b.Solution,b.UniqueFolderID,b.ParentFolderID')->from("{$this->userstable} a")->join("{$this->solutionstable} b","a.id = b.User")->where('a.organisation', $this->organisation )->where('b.User', $this->userid )->where('b.isarchived', $isarchived)->where('b.Type', 'Folder')->limit(20);
		$this->db->where('ParentFolderID',$Parentfolderid);
		$this->db->order_by("idusersolutions","ASC");
		$query = $this->db->get();
		$this->db->last_query();
		$iTems = '';
		if($query -> num_rows() >0 ) {
			$lists = $query->result();
			foreach($lists as $list ):
				$iTems .= '
					<li class="'.$this->droppedSolutionClass.' uk-flex uk-margin-small-bottom" data-solnRowId="'.$list->idusersolutions.'" data-drcurrentbox="'.$nextboxnumer.'" data-Parentfolderid="'.$list->ParentFolderID.'">
					<span class="uk-drag solutionid'.encryptKey($list->idusersolutions).'">'.DRAGHANDLERICON.'</span>	
					<span class="uk-margin-small-right uk-icon" uk-icon="folder"></span> 
						<a class="folderlistboxsection_lia" href="javascript:void(0)" data-Parentfolderid="'.$list->UniqueFolderID.'" data-solnid="'.$list->idusersolutions.'">'.$list->Solution.'<span class="uk-icon" uk-icon="chevron-right"></span></a>
						'.$this->SolutionActionBtns($this->userid,$list->idusersolutions,$list->Type,$list->UniqueFolderID,$list->ParentFolderID,$nextboxnumer).'
					</li>
				';
			endforeach;
		}
		return $iTems;
	}
    public function MakeDuplicateSolutions($userid,$solid,$CopiedSolution,$solnType,$nextboxnumer) {
		if( $solnType == 'CashflowModel') {
			$SQL = "INSERT INTO {$this->solutionstable} (DateTime_Last_Accessed,Parameters,ParentFolderID,Solution,Type,UniqueFolderID,User) SELECT DateTime_Last_Accessed,Parameters,ParentFolderID, '".$CopiedSolution."', Type, UniqueFolderID, ".$userid." FROM `{$this->solutionstable}` WHERE idusersolutions = $solid AND User = ".$userid;
		} else if( $solnType == 'Folder') {
			$NewUniqueFolderID = $this->NextUniqueFolderID();
			$SQL = "INSERT INTO {$this->solutionstable} (DateTime_Last_Accessed,Parameters,ParentFolderID,Solution,Type,UniqueFolderID,User) SELECT DateTime_Last_Accessed,Parameters,ParentFolderID, '".$CopiedSolution."', Type, $NewUniqueFolderID, ".$userid." FROM `{$this->solutionstable}` WHERE idusersolutions = $solid AND User = ".$userid;
		}
		$this->db->query($SQL);
	}
    public function movetowastebasketsolutions($idusersolution) {
		$DraggedInfo  = $this->getsolutionInfo($this->userid,$idusersolution);
		$solnType =$DraggedInfo->Type;
		$expiry_date = date('Y-m-d',strtotime('+'.WASTEBASKETTIME.' days'));
		if( $solnType == 'CashflowModel') {
			$SQL = "UPDATE {$this->solutionstable} SET isarchived = 1,ParentFolderID = NULL,UniqueFolderID = NULL, expiry_date = '".$expiry_date."' WHERE idusersolutions =". $idusersolution ;
		} else if ($solnType == 'Folder' ) {
			$q = $DraggedInfo->UniqueFolderID;
			$SecondChildIDs = $this->db->query("SELECT Distinct UniqueFolderID FROM {$this->solutionstable} WHERE User=$this->userid AND UniqueFolderID is not null AND ParentFolderID =".$DraggedInfo->UniqueFolderID)->row();
			if( !empty($SecondChildIDs->UniqueFolderID) ) {
				$q .= '_'.$SecondChildIDs->UniqueFolderID;
				$ThirdChildIDs = $this->db->query("SELECT Distinct UniqueFolderID FROM {$this->solutionstable} WHERE User=$this->userid AND UniqueFolderID is not null AND ParentFolderID =".$SecondChildIDs->UniqueFolderID)->row();
				if( !empty($ThirdChildIDs->UniqueFolderID) ) {
					$q .= '_'.$ThirdChildIDs->UniqueFolderID;
					$FourthChildIDs = $this->db->query("SELECT Distinct UniqueFolderID FROM {$this->solutionstable} WHERE User=$this->userid AND UniqueFolderID is not null AND ParentFolderID =".$ThirdChildIDs->UniqueFolderID)->row();
					if( !empty($FourthChildIDs->UniqueFolderID) ) {
						$q .= '_'.$FourthChildIDs->UniqueFolderID;
					}
				}
			}
			$arr3 =  explode("_",$q);
			$TextToDo = "";
			for  ($x = 0; $x <= count($arr3)-1; $x++) {
				$TextToDo .= " UniqueFolderID='".$arr3[$x]."' OR";
			}
			for  ($x = 0; $x <= count($arr3)-1; $x++) {
				$TextToDo .= " ParentFolderID='".$arr3[$x]."' OR";
			}
			$TextToDo = mb_substr($TextToDo, 0, -2);
			
			$this->db->select("group_concat(b.idusersolutions) as solutionids")->from("{$this->userstable} a")->join("{$this->solutionstable} b","a.id = b.User")->where('a.organisation', $this->organisation )->where('b.User', $this->userid );
			$this->db->where($TextToDo);
			$query = $this->db->get();
			$this->db->last_query();
			$iTems = '';
			if($query -> num_rows() >0 ) {
				$lists = $query->row();
			}
			$SQL="UPDATE {$this->solutionstable} SET isarchived = 1, expiry_date = '".$expiry_date."', ParentFolderID = case when idusersolutions=$idusersolution then NULL else ParentFolderID end WHERE idusersolutions In ($lists->solutionids)"; 
		}
		$this->db->query($SQL);
		return $DraggedInfo->Solution;
	}

}