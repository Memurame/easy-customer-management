<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\TestimonialFormModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['custom','setting', 'form', 'email'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $formModel = new TestimonialFormModel();
        $forms = $formModel->findAll();

        foreach($forms as $form){
            $formData = json_decode($form->data, true);
            cache()->save('testimonial_'.$form->id.'_raw', $formData);

            $required = [];
            $options = [];
            $fields = [];
            $log = [];
            foreach($formData['sections'] as $section){
                foreach($section['fields'] as $fieldName => $field){
                    $fields[$fieldName] = $field;
                    if(isset($field['required']) && $field['required']){
                        $required[] = $fieldName;
                    }
                    if(isset($field['log']) && $field['log']){
                        $log[] = $fieldName;
                    }
                    if(in_array($field['type'], ['select','checkbox'])){
                        $options[$fieldName] = $field['option'];
                    }
                    if($field['type'] == 'upload'){
                        $files[] = $fieldName;
                    }
                }
            }
            cache()->save('testimonial_'.$form->id.'_required', $required);
            cache()->save('testimonial_'.$form->id.'_log', $log);
            cache()->save('testimonial_'.$form->id.'_options', $options);
            cache()->save('testimonial_'.$form->id.'_fieldNames', $fields);
            cache()->save('testimonial_'.$form->id.'_files', $files);
            cache()->save('testimonial_'.$form->id.'_fields', $fields);
        }
    }
}