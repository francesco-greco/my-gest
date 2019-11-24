<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'dto/processing_stage_dto.php';

class Intervention_note_model extends CH_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('interventions_model');
    }
    
    public function save_note(Intervention_notes_DTO $note){
        $this->processing_note($note->id_intervention, $note->note_code);
        return $this->_insert(Intervention_notes_DTO::TABLE_NAME, $note->get_data_for_db());
    }
    
    public function get_notes_intervention($id_intervention){
        $this->db->from(Intervention_notes_DTO::TABLE_NAME)
                ->where(Intervention_notes_DTO::FIELD_ID_INTERVENTION, $id_intervention);
        $this->db->order_by(Intervention_notes_DTO::FIELD_CREATION_DATE,'DESC');
        return $this->_get_list(Intervention_notes_DTO::class_name());
    }


    private function processing_note($id_intervention, $code) {
        switch ($code) {
            case Intervention_notes_DTO::NOTE_CODE_START_TECNICO:
                $new_processing_stage = Processing_stage_DTO::STAGE_PRODOTTO_DAL_TECNICO;
                break;
            case Intervention_notes_DTO::NOTE_CODE_DIAGNOSI:
                $new_processing_stage = Processing_stage_DTO::STAGE_DIAGNOSI_ESEGUITA;
                break;
            case Intervention_notes_DTO::NOTE_CODE_ESEGUITO:
                $new_processing_stage = Processing_stage_DTO::STAGE_RIPARAZIONE_ESEGUITA;
                break;
            case Intervention_notes_DTO::NOTE_CODE_ATTESA_RICAMBI:
                $new_processing_stage = Processing_stage_DTO::STAGE_ATTESA_RICAMBI_LAVORAZIONE;
                break;
            case Intervention_notes_DTO::NOTE_CODE_CONTATTO_CLIENTE:
                $new_processing_stage = Processing_stage_DTO::STAGE_ATTESA_CLIENTE;
                break;
            case Intervention_notes_DTO::NOTE_CODE_CHECK_RIPARAZIONE:
                $new_processing_stage = Processing_stage_DTO::STAGE_CHECK_RIPARAZIONE;
                break;
            case Intervention_notes_DTO::NOTE_CODE_RITORNO_BANCO:
                $new_processing_stage = Processing_stage_DTO::STAGE_PRODOTTO_RITORNO_BANCO;
                break;
            case Intervention_notes_DTO::NOTE_CODE_ROTTAMAZIONE:
                $new_processing_stage = Processing_stage_DTO::STAGE_RIPARAZIONE_NON_ESEGUITA;
                break;
            case Intervention_notes_DTO::NOTE_CODE_RICONSEGNA_CLIENTE:
                $new_processing_stage = Processing_stage_DTO::STAGE_RICONSEGNA_CLIENTE;
                break;
            default :
                $new_processing_stage = FALSE;
        }
        return $this->set_processing_stage($id_intervention, $new_processing_stage);
    }
    
    public function set_processing_stage($id_intervention, $new_processing_stage) {
        if ($new_processing_stage != FALSE) {
            $dto_processing_stage = $this->interventions_model->get_processing_stage($new_processing_stage);
            $dto_intervention = new Intervention_DTO();
            $dto_intervention->id = $id_intervention;
            $dto_intervention->id_processing_stage = $dto_processing_stage->id;
            if(in_array($new_processing_stage, array(Processing_stage_DTO::STAGE_RIPARAZIONE_NON_ESEGUITA, Processing_stage_DTO::STAGE_RICONSEGNA_CLIENTE))){
                $dto_intervention->status = Intervention_DTO::STATUS_CLOSED;
            }
            return $this->interventions_model->save_intervention($dto_intervention);
        } else {
            return null;
        }
    }

}

