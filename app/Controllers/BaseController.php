<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\TechnicianModel;
use App\Models\CaptureModel;
use App\Models\StatusModel;
use App\Models\MoldScreenModel;
use App\Models\MoldScreenFModel;
use App\Models\MoldScreenHistModel;
use App\Models\MoldModel;
use App\Models\PriorityModel;
use App\Models\ProgressModel;
use App\Models\TypeWorkModel;
use App\Models\PartnerModel;
use App\Models\OrderModel;
use App\Models\RandCodesModel;
use App\Models\CommentOrderModel;
use App\Models\ProfileModel;
use App\Models\OrderStatusModel;
use App\Models\MachineModel;
use App\Models\CommentMoldModel;
use App\Models\UserRoleModel;
use App\Models\SparePartsModel;
use App\Models\ShotsModel;
use App\Models\DepartmentModel;
use CodeIgniter\HTTP\IncomingRequest;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
		$this->user = new UserModel();
		$this->tech = new TechnicianModel();
		$this->mold = new MoldModel();
		$this->status = new StatusModel();
		$this->type_work = new TypeWorkModel();
		$this->priority = new PriorityModel();
		$this->capture = new CaptureModel();
		$this->order = new OrderModel();
		$this->com = new CommentOrderModel();
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		$this->rcm = new RandCodesModel();
		$this->profile = new ProfileModel();
		$this->ot_status = new OrderStatusModel();
		$this->partner = new PartnerModel();
		$this->ms = new MoldScreenModel();
		$this->msf = new MoldScreenFModel();
		$this->msh = new MoldScreenHistModel();
		$this->progress = new ProgressModel();
		$this->machine = new MachineModel();
		$this->comment_mold = new CommentMoldModel();
		$this->comment = new CommentOrderModel();
		$this->role = new UserRoleModel();
		$this->spareparts = new SparePartsModel();
		$this->shots = new ShotsModel();
		$this->department = new DepartmentModel();
		$this->title = "MoldSFC | ";
	}

}
