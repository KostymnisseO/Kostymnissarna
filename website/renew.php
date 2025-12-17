<?php
    include_once "shared/sessionmanager.php";
    include_once "shared/erpnextinterface.php";
    $sesh = new SessionManager();
    
    if (!$sesh->active())
    {
        header("Location: logout.php");
        exit();
    }
    else
    {
        if (isset($_POST['presc']) and !empty($_POST['presc']))
        {
            $erp = new ERPNextInterface();
            $fields_arr = [];
            $required_fields = [
                'medication_item'
                , 'medication'
                , 'patient'
                , 'practitioner'
                , 'dosage_form'
                , 'dosage'
            ];
            $created = [];

            $previous = $erp->fetchDocType('Medication Request', $_POST['presc']);
            $drafts = $erp->fetchAll(
                'Medication Request'
                , filters: [
                    ['Medication Request', 'patient_name', '=', $previous['data']['patient']]
                    , ['Medication Request', 'status', 'like', 'draft%']
                    , ['Medication Request', 'medication_item', '=', $previous['data']['medication_item']]
                ]
                , fields: ['medication_item']
            );
            
            if (sizeof($drafts['data']) == 0)
            {
                foreach ($required_fields as $field)
                {
                    $fields_arr[$field] = $previous['data'][$field];
                }
                
                $created = $erp->createDocType('Medication Request', fields: $fields_arr);
            }
            else
            {
                echo "Existing renewal found";
            }
            
            if ($not_debugging = true)
            {
                header("Location: treatments.php");
                exit();
            }
            
            /* --- DEBUG OUTPUTS --- */
            echo '<h2>' . 'Retrieved from ERPNext:' . '</h2>';
            echo '<pre>';
            print_r($previous['data']);
            echo '</pre>';
            
            echo 
                '<h2>' . 'Submitted:' . '</h2>' .
                '<h3>' . 'Array:' . '</h3>'.
                '<pre>';
                    print_r($fields_arr);
            echo '</pre>';
            
            echo 
                '<h3>' . 'JSON:' . '</h3>' .
                '<pre>' .
                json_encode($fields_arr) .
                '</pre>';
                
            echo '<h2>' . 'Response:' . '</h2>';
            echo '<pre>';
            print_r($created);
            echo '</pre>';
        }
        
    }
?>
