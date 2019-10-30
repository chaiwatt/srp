<?php

use App\Model\RegisterDocument;
/*
	frontend route
*/



Route::group(['prefix' => 'landing'] , function(){
	Route::get('/' , 'LandingPageController@Index');				
	Route::get('appication' , 'LandingPageController@Application');
	Route::get('about' , 'LandingPageController@Application');
	Route::get('blog/{id}' , 'SingleBlogController@Index');
	Route::post('searchblog' , 'SingleBlogController@Search');
	Route::get('blog' , 'SingleBlogController@Blog');
	Route::group(['prefix' => 'register'] , function(){
		Route::get('/' , 'ContractorOnlineRegisterController@Index');
		Route::post('create' , 'ContractorOnlineRegisterController@CreateSave');
	});
});

Route::group(['prefix' => 'publicreport'] , function(){
	Route::get('report' , 'PublicReportController@Report');		
	Route::get('allocation' , 'PublicReportController@Allocation');		
	Route::get('expense' , 'PublicReportController@Expense');	
	Route::get('readiness' , 'PublicReportController@Readiness');	
	Route::get('occupation' , 'PublicReportController@Occupation');	
	Route::get('hasincome' , 'PublicReportController@HasIncome');	
	Route::get('enoughincome' , 'PublicReportController@EnoughIncome');	
});

Route::get('api/winlogin', 'ApiController@CheckWinLogin'); //ทะเบียนราษฎ์

Route::get('api/register-smartcard', 'ApiController@RegisterSmartCard'); //offline
Route::get('api/register-smartcardbydept', 'ApiController@RegisterSmartCardByDept'); //server กรมคุมประพฤติ
Route::get('api/register-smartcardbydeptrt', 'ApiController@RegisterSmartCardByDeptRT'); //server กรมคุมประพฤติ
Route::get('api/register-smartcardbydeptpn', 'ApiController@RegisterSmartCardByDeptPN'); //server กรมคุมพินิจ
Route::get('api/register-smartcardgovernment', 'ApiController@RegisterSmartCardGovernment'); //ทะเบียนราษฎ์
Route::get('api/addassessment', 'ApiController@AddAssessment'); //ทะเบียนราษฎ์

Route::get('/' , 'AuthController@LoginPage'); // page login
Route::post('login' , 'AuthController@Login'); // action login

Route::group(['prefix' => 'api'] , function(){
	Route::get('budget' , 'ApiController@Budget');
	Route::get('projectallocation' , 'ApiController@ProjectAllocation');
	Route::get('department' , 'ApiController@Department');
	Route::get('prefix' , 'ApiController@Prefix');
	Route::get('skill' , 'ApiController@Skill');
	Route::get('software' , 'ApiController@Software');
	Route::get('military' , 'ApiController@Military');
	Route::get('married' , 'ApiController@Married');
	Route::get('religion' , 'ApiController@Religion');
	Route::get('province' , 'ApiController@Province');
	Route::get('amphur' , 'ApiController@Amphur');
	Route::get('district' , 'ApiController@District');
	Route::get('position' , 'ApiController@Position');
	Route::get('contractorposition' , 'ApiController@Position2');
	Route::get('group' , 'ApiController@Group');
	Route::get('register-person' , 'ApiController@RegisterPerson');
	Route::get('active-person' , 'ApiController@ActivePerson');
	Route::get('check-person' , 'ApiController@CheckPerson');
	Route::get('registertype' , 'ApiController@Registertype');
	Route::get('sectionexist' , 'ApiController@SectionExist');
	Route::get('deleteparticipate' , 'ApiController@DeleteParticipate');
	Route::get('deletetrainer' , 'ApiController@DeleteTrainer');
	Route::get('deleteregisterexpereince' , 'ApiController@DeleteRegisterExpereince');
	Route::get('deleteregistertraining' , 'ApiController@DeleteRegisterTraining');
	Route::get('deleteauthority' , 'ApiController@DeleteAuthority');
	Route::get('deletecompany' , 'ApiController@DeleteCompany');
	Route::get('deletecontractorexp' , 'ApiController@DeleteContractorExpereince');
	Route::get('deleteinterviewee' , 'ApiController@DeleteInterviewee');
	Route::get('deleteinterviewer' , 'ApiController@DeleteInterviewer');
	Route::get('deleteassessor' , 'ApiController@DeleteAssessor');
	Route::get('register-contractor' , 'ApiController@RegisterContractor');
	Route::get('sectionlist' , 'ApiController@GetSection');
	Route::get('section' , 'ApiController@Section');

	Route::group(['prefix' => 'report'] , function(){
			Route::group(['prefix' => 'department'] , function(){
				Route::get('recurit' , 'ApiController@DeptReportRecurit');
				Route::get('budget' , 'ApiController@DeptReportRecuritBudget');
				Route::get('readiness' , 'ApiController@DeptReportReadiness');
				Route::get('occupation' , 'ApiController@DeptReportOccupation');
				Route::get('occupationfollowup' , 'ApiController@DeptReportOccupationFollowup');
				Route::get('occupationfollowupenoughexpense' , 'ApiController@DeptReportOccupationFollowupEnoughExpense');

			});
			Route::group(['prefix' => 'main'] , function(){
				Route::get('recurit' , 'ApiController@MainReportRecurit');
				Route::get('budget' , 'ApiController@MainReportRecuritBudget');
				Route::get('occupation' , 'ApiController@MainReportOccupation');
				Route::get('readiness' , 'ApiController@MainReportReadiness');
				Route::get('hasincome' , 'ApiController@MainReportOccupationFollowup');
				Route::get('enoughincome' , 'ApiController@MainReportEnoughIncome');
			});
	});

});


Route::group(['middleware' => 'auth'] , function(){

	// Route::get('404' , 'ErrorController@notfound')->name('404');
	// Route::get('500' , 'ErrorController@fatal')->name('500');

	Route::group(['prefix' => 'videolist'] , function(){
		Route::get('' , 'VideoListController@Index')->name('videolist.index'); // action login
		Route::get('play/{id}' , 'VideoListController@play')->name('videolist.play'); // action login
	});
	Route::get('logout' , 'AuthController@Logout'); // action login

	Route::group(['prefix' => 'deletedb'] , function(){
		Route::get('/' , 'DeleteDbController@Index');
		Route::get('deleteallocation' , 'DeleteDbController@DeleteAllocation');
		Route::get('deleteallocationtransaction' , 'DeleteDbController@DeleteAllocationTransaction');
		Route::get('deleteallocationwaiting' , 'DeleteDbController@DeleteAllocationWaiting');
		Route::get('deleteassessor' , 'DeleteDbController@DeleteAssessor');
		Route::get('deletebackuphistory' , 'DeleteDbController@DeleteBackuphistory');
		Route::get('deletecompany' , 'DeleteDbController@DeleteCompany');
		Route::get('deletecontractor' , 'DeleteDbController@DeleteContractor');
		Route::get('deletecontractordocument' , 'DeleteDbController@DeleteContractorDocument');
		Route::get('deletecontractoreducation' , 'DeleteDbController@DeleteContractorEducation');
		Route::get('deletecontractoremploy' , 'DeleteDbController@DeleteContractorEmploy');
		Route::get('deletecontractorexperience' , 'DeleteDbController@DeleteContractorExperience');
		Route::get('deletecontractorskill' , 'DeleteDbController@DeleteContractorSkill');
		Route::get('deletecontractorsoftware' , 'DeleteDbController@DeleteContractorSoftware');
		Route::get('deletecontractortraining' , 'DeleteDbController@DeleteContractorTraining');
		Route::get('deletedocdownload' , 'DeleteDbController@DeletedocDownload');
		Route::get('deleteemploy' , 'DeleteDbController@DeleteEmploy');
		Route::get('deletefollowupinterview' , 'DeleteDbController@DeleteFollowupInterview');
		Route::get('deletefollowupregister' , 'DeleteDbController@DeleteFollowupRegister');
		Route::get('deletefollowupsection' , 'DeleteDbController@DeleteFollowupSection');
		Route::get('deletegenerate' , 'DeleteDbController@DeleteGenerate');
		Route::get('deleteinformation' , 'DeleteDbController@DeleteInformation');
		Route::get('deleteinformationexpense' , 'DeleteDbController@DeleteInformationExpense');
		Route::get('deleteinformationpicture' , 'DeleteDbController@DeleteInformationPicture');
		Route::get('deleteinterviewee' , 'DeleteDbController@DeleteInterviewee');
		Route::get('deleteinterviewer' , 'DeleteDbController@DeleteInterviewer');
		Route::get('deletelinemessage' , 'DeleteDbController@DeleteLineMessage');
		Route::get('deletelogfile' , 'DeleteDbController@DeleteLogfile');
		Route::get('deletenotifymessage' , 'DeleteDbController@DeleteNotifyMessage');
		Route::get('deleteparticipategroup' , 'DeleteDbController@DeleteParticipateGroup');
		Route::get('deletepayment' , 'DeleteDbController@DeletePayment');
		Route::get('deletepersonalassessment' , 'DeleteDbController@DeletePersonalAssessment');
		Route::get('deleteproject' , 'DeleteDbController@DeleteProject');
		Route::get('deleteprojectassessment' , 'DeleteDbController@DeleteProjectAssessment');
		Route::get('deleteprojectbudget' , 'DeleteDbController@DeleteProjectBudget');
		Route::get('deleteprojectfollowup' , 'DeleteDbController@DeleteProjectFollowup');
		Route::get('deleteprojectfollowupdocument' , 'DeleteDbController@DeleteProjectFollowupDocument');
		Route::get('deleteprojectparticipate' , 'DeleteDbController@DeleteProjectParticipate');
		Route::get('deleteprojectreadiness' , 'DeleteDbController@DeleteProjectReadiness');
		Route::get('deleteprojectreadinessofficer' , 'DeleteDbController@DeleteProjectReadinessOfficer');
		Route::get('deleteprojectsurvey' , 'DeleteDbController@DeleteProjectSurvey');
		Route::get('deletereadinessexpense' , 'DeleteDbController@DeleteReadinessExpense');
		Route::get('deletereadinessection' , 'DeleteDbController@DeleteReadinesSection');
		Route::get('deletereadinessectiondocument' , 'DeleteDbController@DeleteReadinesSectionDocument');
		Route::get('deleterefund' , 'DeleteDbController@DeleteRefund');
		Route::get('deleteregister' , 'DeleteDbController@DeleteRegister');
		Route::get('deleteregisterassesmentfit' , 'DeleteDbController@DeleteRegisterAssesmentFit');
		Route::get('deleteregisterassesment' , 'DeleteDbController@DeleteRegisterAssesment');
		Route::get('deleteregisterdocument' , 'DeleteDbController@DeleteRegisterDocument');
		Route::get('deleteregistereducation' , 'DeleteDbController@DeleteRegisterEducation');
		Route::get('deleteregisterexperience' , 'DeleteDbController@DeleteRegisterExperience');
		Route::get('deleteregisterskill' , 'DeleteDbController@DeleteRegisterSkill');
		Route::get('deleteregistersoftware' , 'DeleteDbController@DeleteRegisterSoftware');
		Route::get('deleteregistertraining' , 'DeleteDbController@DeleteRegisterTraining');
		Route::get('deleteresign' , 'DeleteDbController@DeleteResign');
		Route::get('deletesettingbudget' , 'DeleteDbController@DeleteSettingBudget');
		Route::get('deletesettingdepartment' , 'DeleteDbController@DeleteSettingDepartment');
		Route::get('deletesurvey' , 'DeleteDbController@DeleteSurvey');
		Route::get('deletesurveyhost' , 'DeleteDbController@DeleteSurveyHost');
		Route::get('deletetrainer' , 'DeleteDbController@DeleteTrainer');
		Route::get('deletetransfer' , 'DeleteDbController@DeleteTransfer');
		Route::get('deletetransfertransaction' , 'DeleteDbController@DeleteTransferTransaction');

	});	
	
	Route::group(['prefix' => 'assesment'] , function(){
		Route::group(['prefix' => 'section'] , function(){
			Route::get('/' , 'AssesmentSectionController@Index');
			Route::get('edit/{id}' , 'AssesmentSectionController@edit');
			Route::get('assessmentedit/{id}' , 'AssesmentSectionController@AssessmentEdit');
			Route::get('followupedit/{id}' , 'AssesmentSectionController@FollowupEdit');
			Route::get('delete/{id}' , 'AssesmentSectionController@Delete');
			Route::get('create' , 'AssesmentSectionController@Create');
			Route::post('create' , 'AssesmentSectionController@CreateSave');
			Route::post('save' , 'AssesmentSectionController@EditSave');
			Route::post('assessmentsave' , 'AssesmentSectionController@AssessmentSave');
			Route::post('followupsave' , 'AssesmentSectionController@FollowupSave');
			Route::get('followupdetail' , 'AssesmentSectionController@FollowupDetail');
			Route::get('editassessment/{id}' , 'AssesmentSectionController@EditAssessment');
			Route::post('editassessment' , 'AssesmentSectionController@EditAssessmentSave');
			Route::get('view/{id}' , 'AssesmentSectionController@View');
			Route::get('editassesee/{id}/{assessmentid}' , 'AssesmentSectionController@EditAssessee');
			Route::post('asseseesave' , 'AssesmentSectionController@EditAssesseeSave');
			Route::get('deleteassesee/{id}/{assessmentid}' , 'AssesmentSectionController@DeleteAssesee');
			Route::get('assesmentexcel/{id}' , 'AssesmentSectionController@AssesmentExcel');
			
			
		});
	});

	Route::group(['prefix' => 'followup'] , function(){
			Route::get('/' , 'FollowupController@Index');
			Route::get('manage/{id}' , 'FollowupController@Manage');
			Route::post('manage' , 'FollowupController@ManageSave');
			Route::get('delete/{id}' , 'FollowupController@Delete');
			Route::get('create' , 'FollowupController@Create');
			Route::post('create' , 'FollowupController@CreateSave');
			Route::get('edit/{id}' , 'FollowupController@Edit');
			Route::post('edit' , 'FollowupController@EditSave');
			Route::get('test' , 'FollowupController@TestCommand');
			Route::get('editreg/{id}' , 'FollowupController@EditReg');
			Route::get('delete-file/{id}' , 'FollowupController@DeleteFile');

			Route::group(['prefix' => 'report'] , function(){
				Route::group(['prefix' => 'department'] , function(){
					Route::get('/' , 'FollowupReportDepartmentController@Index');
				});
			});	

			Route::group(['prefix' => 'refund'] , function(){
				Route::get('/' , 'FollowupRefundController@Index');
				Route::post('save' , 'FollowupRefundController@SaveEdit');
			});				
	});	

	Route::group(['prefix' => 'linenotify'] , function(){
		Route::get('/{id}' , 'LineNotifyController@SuperAdminLineNotify');
	});

	Route::group(['prefix' => 'recurit'] , function(){

		Route::group(['prefix' => 'report'] , function(){

			Route::get('/' , 'RecuritReportController@Index');
			Route::get('payment' , 'RecuritReportController@Payment');
			Route::get('payment/department/{id}' , 'RecuritReportController@PaymentDepartment');
			Route::get('payment/section/{id}' , 'RecuritReportController@PaymentSection');

			Route::group(['prefix' => 'main'] , function(){
				Route::group(['prefix' => 'survey'] , function(){
					Route::get('/' , 'RecuritReportMainSurveyController@Index');
					Route::get('pdf' , 'RecuritReportMainSurveyController@ExportPDF');
				});
				Route::group(['prefix' => 'resign'] , function(){
					Route::get('/' , 'RecuritReportMainResignController@Index');
					Route::get('pdf' , 'RecuritReportMainResignController@ExportPDF')->name('resign.main.export.pdf');
				});
				Route::group(['prefix' => 'cancel'] , function(){
					Route::get('/' , 'RecuritReportMainCancelController@Index');
					Route::get('pdf' , 'RecuritReportMainCancelController@ExportPDF')->name('cancel.main.export.pdf');
				});


				Route::group(['prefix' => 'assessment'] , function(){
					Route::get('/' , 'RecuritReportMainAssessmentController@Index');
				    Route::get('pdf' , 'RecuritReportMainAssessmentController@ExportPDF');
					Route::get('excel' , 'RecuritReportMainAssessmentController@ExportExcel');
					Route::get('word' , 'RecuritReportMainAssessmentController@ExportWord');
				});

			});

			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'RecuritReportDepartmentController@Index');
				Route::get('sum' , 'RecuritReportDepartmentController@Sum');
				Route::get('payment' , 'RecuritReportDepartmentController@Payment');
				Route::get('payment/view/{id}' , 'RecuritReportDepartmentController@PaymentView');

				Route::group(['prefix' => 'survey'] , function(){
					Route::get('/' , 'RecuritReportDepartmentSurveyController@Index');
					Route::get('pdf' , 'RecuritReportDepartmentSurveyController@ExportPDF');
				});

				Route::group(['prefix' => 'resign'] , function(){
					Route::get('/' , 'RecuritReportDepartmentResignController@Index');
					Route::get('pdf' , 'RecuritReportDepartmentResignController@ExportPDF')->name('resign.department.export.pdf');
				});

				Route::group(['prefix' => 'cancel'] , function(){
					Route::get('/' , 'RecuritReportDepartmentCancelController@Index');
					Route::get('pdf' , 'RecuritReportDepartmentCancelController@ExportPDF')->name('cancel.department.export.pdf');
				});

				Route::group(['prefix' => 'assessment'] , function(){
					Route::get('/' , 'RecuritReportDepartmentAssessmentController@Index');
				    Route::get('pdf' , 'RecuritReportDepartmentAssessmentController@ExportPDF');
					Route::get('excel' , 'RecuritReportDepartmentAssessmentController@ExportExcel');
					Route::get('word' , 'RecuritReportDepartmentAssessmentController@ExportWord');
				});

				Route::group(['prefix' => 'recurit'] , function(){
					Route::get('/' , 'RecuritReportDepartmentRecuritController@Index');
					Route::get('pdf/{month}/{quater}' , 'RecuritReportDepartmentRecuritController@ExportPDF')->name('recurit.report.department.recurit.export.pdf'); 
					Route::get('excel/{month}/{quater}' , 'RecuritReportDepartmentRecuritController@ExportExcel')->name('recurit.report.department.recurit.export.excel'); 

				});

			});

			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritReportSectionController@Index');
				Route::get('payment' , 'RecuritReportSectionController@Payment');
				Route::get('pdf/{month}/{quater}' , 'RecuritReportSectionController@ExportPDF')->name('recurit.report.section.export.pdf');
				Route::get('excel/{month}/{quater}' , 'RecuritReportSectionController@ExportExcel')->name('recurit.report.section.export.excel');
				Route::group(['prefix' => 'allpayment'] , function(){
					Route::get('/' , 'RecuritReportSectionAllpaymentController@Index');
					Route::get('pdf/{month}/{quater}' , 'RecuritReportSectionAllpaymentController@ExportPDF')->name('recurit.report.section.allpayment.export.pdf');
					Route::get('excel/{month}/{quater}' , 'RecuritReportSectionAllpaymentController@ExportExcel')->name('recurit.report.section.allpayment.export.excel'); 
				});
				Route::group(['prefix' => 'personal'] , function(){
					Route::get('/' , 'RecuritReportSectionPersonalController@Index');
					Route::get('pdf/{id}' , 'RecuritReportSectionPersonalController@ExportPDF');
					Route::get('excel/{id}' , 'RecuritReportSectionPersonalController@ExportExcel');
				});
				Route::group(['prefix' => 'resign'] , function(){
					Route::get('/' , 'RecuritReportSectionResignController@Index');
					Route::get('pdf/{month}/{quater}' , 'RecuritReportSectionResignController@ExportPDF')->name('recurit.report.section.resign.export.pdf'); 
					Route::get('excel/{month}/{quater}' , 'RecuritReportSectionResignController@ExportExcel')->name('recurit.report.section.resign.export.excel'); 
				});
				Route::group(['prefix' => 'cancel'] , function(){
					Route::get('/' , 'RecuritReportSectionCancelController@Index');
					Route::get('pdf/{month}/{quater}' , 'RecuritReportSectionCancelController@ExportPDF')->name('recurit.report.section.cancel.export.pdf'); 
					Route::get('excel/{month}/{quater}' , 'RecuritReportSectionCancelController@ExportExcel')->name('recurit.report.section.cancel.export.excel'); 
				});
				Route::group(['prefix' => 'recurit'] , function(){
					Route::get('/' , 'RecuritReportSectionRecuritController@Index');
					Route::get('pdf/{month}/{quater}' , 'RecuritReportSectionRecuritController@ExportPDF')->name('recurit.report.section.recurit.export.pdf'); 
					Route::get('excel/{month}/{quater}' , 'RecuritReportSectionRecuritController@ExportExcel')->name('recurit.report.section.recurit.export.excel'); 

				});
			});

		});

		Route::group(['prefix' => 'refund'] , function(){
			Route::group(['prefix' => 'department'] , function(){
				Route::get('view' , 'RecuritRefundDepartmentController@View');
				Route::get('view/confirm/{id}' , 'RecuritRefundDepartmentController@ViewConfirm');
				Route::get('/' , 'RecuritRefundDepartmentController@Index');
				Route::post('/' , 'RecuritRefundDepartmentController@IndexSave');
			});

			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritRefundSectionController@Index');
				Route::get('confirm/{id}' , 'RecuritRefundSectionController@Confirm');
				Route::get('confirmanual/{id}' , 'RecuritRefundSectionController@ConfirmAnual');
			});

		});

		Route::group(['prefix' => 'resign'] , function(){
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritResignSectionController@Index');
				Route::get('create' , 'RecuritResignSectionController@Create');
				Route::post('create' , 'RecuritResignSectionController@CreateSave');
				Route::get('delete/{id}' , 'RecuritResignSectionController@DeleteSave');
			});
		});

		Route::group(['prefix' => 'cancel'] , function(){
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritCancelSectionController@Index');
				Route::get('create' , 'RecuritCancelSectionController@Create');
				Route::post('create' , 'RecuritCancelSectionController@CreateSave');
				Route::get('delete/{id}' , 'RecuritCancelSectionController@DeleteSave');
			});
		});

		Route::group(['prefix' => 'payment'] , function(){
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritPaymentSectionController@Index');
				Route::get('list' , 'RecuritPaymentSectionController@Lists');
				Route::get('create/{id}' , 'RecuritPaymentSectionController@Create');
				Route::post('create' , 'RecuritPaymentSectionController@CreateSave');
				Route::get('edit/{id}' , 'RecuritPaymentSectionController@Edit');
				Route::post('edit' , 'RecuritPaymentSectionController@EditSave');
				Route::get('delete/{id}' , 'RecuritPaymentSectionController@DeleteSave');
				Route::get('view/{id}' , 'RecuritPaymentSectionController@View');
			});
		});

		Route::group(['prefix' => 'hire'] , function(){
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritHireSectionController@Index');
				Route::get('create/{id}' , 'RecuritHireSectionController@Create');
				Route::get('createsave/{id}' , 'RecuritHireSectionController@CreateSave');
				Route::get('view/{id}' , 'RecuritHireSectionController@View');
				Route::get('history/{id}' , 'RecuritHireSectionController@History');
				Route::get('editnummonth/{id}' , 'RecuritHireSectionController@EditNumMonth');
				Route::post('edit/{id}' , 'RecuritHireSectionController@EditNumMonthSave');
				Route::group(['prefix' => 'view'] , function(){
					Route::get('/' , 'RecuritHireSectionViewController@Index');
				});
			});

		});

		Route::group(['prefix' => 'assesment'] , function(){
			Route::get('/' , 'RecuritAssesment@Index');
			Route::get('create/{id}' , 'RecuritAssesment@Create');
			Route::post('create' , 'RecuritAssesment@CreateSave');
			Route::get('view/{id}' , 'RecuritAssesment@View');
			Route::get('edit/{id}' , 'RecuritAssesment@Edit');
			Route::post('edit' , 'RecuritAssesment@EditSave');
			Route::get('delete/{id}' , 'RecuritAssesment@Delete');
			Route::get('deleteattachment/{id}' , 'RecuritAssesment@DeleteAttachment');
			Route::get('deleteall/{id}' , 'RecuritAssesment@DeleteAll');
			Route::group(['prefix' => 'report'] , function(){
				Route::get('/' , 'RecuritAssesmentReport@Index');
				Route::get('download/{id}' , 'RecuritAssesmentReport@Download');
			});
		});

		Route::group(['prefix' => 'register'] , function(){
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritRegisterSectionController@Index');
				Route::get('create' , 'RecuritRegisterSectionController@Create');
				Route::post('create' , 'RecuritRegisterSectionController@CreateSave');
				Route::get('edit/{id}' , 'RecuritRegisterSectionController@Edit');
				Route::post('edit' , 'RecuritRegisterSectionController@EditSave');
				Route::get('delete-file/{id}' , 'RecuritRegisterSectionController@DeleteFile');
				Route::get('delete/{id}' , 'RecuritRegisterSectionController@DeleteSave');
				Route::get('compact/{id}' , 'RecuritRegisterSectionController@Compact');
				Route::get('createcert/{id}' , 'RecuritRegisterSectionController@CreateCert');
				Route::post('createcert' , 'RecuritRegisterSectionController@CreateCertSave');
				Route::get('application/{id}' , 'RecuritRegisterSectionController@Application');
			});
		});

		Route::group(['prefix' => 'employ'] , function(){
			Route::get('/' , 'RecuritEmployController@Index');
			Route::post('/' , 'RecuritEmployController@EmploySave');
			// Route::group(['prefix' => 'department'] , function(){
				// Route::get('/' , 'RecuritEmployDepartmentController@Index');
				// Route::get('create' , 'RecuritEmployDepartmentController@Create');
				// Route::post('create' , 'RecuritEmployDepartmentController@CreateSave');
			// });
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritEmploySectionController@Index');
				Route::get('create' , 'RecuritEmploySectionController@Create');
				Route::post('create' , 'RecuritEmploySectionController@CreateSave');

			});
		});

		Route::group(['prefix' => 'survey'] , function(){
			Route::get('/' , 'RecuritSurveyController@Index');
			Route::get('create' , 'RecuritSurveyController@Create');
			Route::post('create' , 'RecuritSurveyController@CreateSave');
			Route::get('edit/{id}' , 'RecuritSurveyController@Edit');
			Route::post('edit' , 'RecuritSurveyController@EditSave');
			Route::get('view/{id}' , 'RecuritSurveyController@View');

			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'RecuritSurveySectionController@Index');
				Route::get('create/{id}' , 'RecuritSurveySectionController@Create');
				Route::post('create' , 'RecuritSurveySectionController@CreateSave');
			});
		});
	});
	
	Route::group(['prefix' => 'message'] , function(){
		Route::get('read/{id}' , 'NotifyMessagesController@ReadMessage');
	
	});	

	Route::group(['prefix' => 'readiness'] , function(){
		Route::group(['prefix' => 'project'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ProjectReadinessMainController@Index');
				Route::get('confirm' , 'ProjectReadinessMainController@Confirm');
				Route::get('approve/{id}' , 'ProjectReadinessMainController@Approve');
				Route::get('edit/{id}' , 'ProjectReadinessMainController@Edit');
				Route::post('edit' , 'ProjectReadinessMainController@EditSave');
			});
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ProjectReadinessDepartmentController@Index');
				Route::get('create' , 'ProjectReadinessDepartmentController@Create');
				Route::get('edit/{id}' , 'ProjectReadinessDepartmentController@Edit');
				Route::get('delete/{id}' , 'ProjectReadinessDepartmentController@Delete');
				Route::post('edit' , 'ProjectReadinessDepartmentController@EditSave');
				Route::post('save' , 'ProjectReadinessDepartmentController@CreateSave');
				Route::get('register' , 'ProjectReadinessDepartmentController@Register');
				Route::get('manage/{id}' , 'ProjectReadinessDepartmentController@Manage');
				Route::post('manage' , 'ProjectReadinessDepartmentController@ManageSave');
				Route::post('expense' , 'ProjectReadinessDepartmentController@Expense');
				Route::get('sectionlist/{id}' , 'ProjectReadinessDepartmentController@SectionList');
				Route::get('approve' , 'ProjectReadinessDepartmentController@ApproveToggle');
				
			});
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'ReadinessProjectSectionController@Index');
				Route::get('list' , 'ReadinessProjectSectionController@List');
				Route::get('toggle' , 'ReadinessProjectSectionController@ToggleSection');
				Route::get('manage/{id}' , 'ReadinessProjectSectionController@Manage');
				Route::get('refund/{id}' , 'ReadinessProjectSectionController@Refund');
				Route::get('refundlist' , 'ReadinessProjectSectionController@RefundList');
				Route::post('manage' , 'ReadinessProjectSectionController@ManageSave');
				Route::get('register' , 'ReadinessProjectSectionController@Register');
				Route::get('deletefile/{id}' , 'ReadinessProjectSectionController@DeleteFile');
				
			});
		});
		
		Route::group(['prefix' => 'report'] , function(){
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ReadinessReportDepartmentController@Index');				
				//Route::get('create/{id}' , 'ExpenseReadinessDepartmentController@Create');	
			});
		});

		Route::group(['prefix' => 'refund'] , function(){
			Route::get('/' , 'ReadinessRefundController@Index');
			Route::post('edit' , 'ReadinessRefundController@SaveEdit');
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ReadinessRefundDepartmentController@Index');
				Route::get('confirm/{id}' , 'ReadinessRefundDepartmentController@Confirm');
			});
		});

	});


	Route::group(['prefix' => 'occupation'] , function(){
		Route::group(['prefix' => 'project'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ProjectOccupationMainController@Index');
				Route::get('confirm' , 'ProjectOccupationMainController@Confirm');
				Route::get('approve/{id}' , 'ProjectOccupationMainController@Approve');
				Route::get('edit/{id}' , 'ProjectOccupationMainController@Edit');
				Route::post('edit' , 'ProjectOccupationMainController@EditSave');
			});
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ProjectOccupationDepartmentController@Index');
				Route::get('create' , 'ProjectOccupationDepartmentController@Create');
				Route::get('edit/{id}' , 'ProjectOccupationDepartmentController@Edit');
				Route::get('delete/{id}' , 'ProjectOccupationDepartmentController@Delete');
				Route::post('edit' , 'ProjectOccupationDepartmentController@EditSave');
				Route::post('save' , 'ProjectOccupationDepartmentController@CreateSave');
				Route::get('register' , 'ProjectOccupationDepartmentController@Register');
				Route::get('manage/{id}' , 'ProjectOccupationDepartmentController@Manage');
				Route::post('manage' , 'ProjectOccupationDepartmentController@ManageSave');
				Route::post('expense' , 'ProjectOccupationDepartmentController@Expense');
				Route::get('sectionlist/{id}' , 'ProjectOccupationDepartmentController@SectionList');
				
			});
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'OccupationProjectSectionController@Index');
				Route::get('list' , 'OccupationProjectSectionController@List');
				Route::get('toggle' , 'OccupationProjectSectionController@ToggleSection');
				Route::get('manage/{id}' , 'OccupationProjectSectionController@Manage');
				Route::get('refund/{id}' , 'OccupationProjectSectionController@Refund');
				Route::get('refundlist' , 'OccupationProjectSectionController@RefundList');
				Route::post('manage' , 'OccupationProjectSectionController@ManageSave');
				Route::get('register' , 'OccupationProjectSectionController@Register');
				Route::get('deletefile/{id}' , 'OccupationProjectSectionController@DeleteFile');
				
			});

		});
		
		Route::group(['prefix' => 'report'] , function(){
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'OccupationReportDepartmentController@Index');				
			});
		});

		Route::group(['prefix' => 'refund'] , function(){
			Route::get('/' , 'OccupationRefundController@Index');
			Route::post('edit' , 'OccupationRefundController@SaveEdit');
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'OccupationRefundDepartmentController@Index');
				Route::get('confirm/{id}' , 'OccupationRefundDepartmentController@Confirm');
			});
		});

	});	

	Route::group(['prefix' => 'information'] , function(){
		Route::get('/' , 'InformationController@Index');
		Route::get('create' , 'InformationController@Create');
		Route::post('create' , 'InformationController@CreateSave');
		Route::get('edit/{id}' , 'InformationController@Edit');
		Route::post('edit' , 'InformationController@EditSave');
		Route::get('delete/{id}' , 'InformationController@DeleteSave');
		Route::get('delete-picture/{id}/{postid}' , 'InformationController@DeletePictureSave');
		
		Route::group(['prefix' => 'expense'] , function(){
			Route::get('/' , 'InformationExpenseController@Index');
			Route::get('create' , 'InformationExpenseController@Create');
			Route::post('create' , 'InformationExpenseController@CreateSave');
		});

		Route::group(['prefix' => 'refund'] , function(){
			Route::get('/' , 'InformationRefundController@Index');
			Route::get('confirm' , 'InformationRefundController@Confirm');
			Route::post('edit' , 'InformationRefundController@SaveEdit');
			
		});

		Route::group(['prefix' => 'report'] , function(){
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'InformationReportDepartmentController@index');
			});
		});

	});



	Route::group(['prefix' => 'contractor'] , function(){

		Route::group(['prefix' => 'register'] , function(){
			Route::get('/' , 'ContractorRegisterController@Index');
			Route::get('delete-file/{id}' , 'ContractorRegisterController@DeleteFile');
			Route::get('create' , 'ContractorRegisterController@Create');
			Route::post('create' , 'ContractorRegisterController@CreateSave');
			Route::get('edit/{id}' , 'ContractorRegisterController@Edit');
			Route::post('edit' , 'ContractorRegisterController@EditSave');
			Route::get('compact/{id}' , 'ContractorRegisterController@Compact');
			Route::get('application/{id}' , 'ContractorRegisterController@Application');
		});

		Route::group(['prefix' => 'payment'] , function(){
			Route::get('/' , 'ContactorPaymentController@Index');
			Route::get('list' , 'ContactorPaymentController@Lists');
			Route::get('create/{id}' , 'ContactorPaymentController@Create');
			Route::post('create' , 'ContactorPaymentController@CreateSave');
			Route::get('edit/{id}' , 'ContactorPaymentController@Edit');
			Route::post('edit' , 'ContactorPaymentController@EditSave');
			Route::get('delete/{id}' , 'ContactorPaymentController@DeleteSave');
			Route::get('view/{id}' , 'ContactorPaymentController@View');
			Route::get('history/{id}' , 'ContactorPaymentController@History');
			Route::group(['prefix' => 'list'] , function(){
				Route::get('/' , 'ContactorPaymentListController@Index');
				Route::get('edit/{id}' , 'ContactorPaymentListController@Edit');
				Route::post('edit' , 'ContactorPaymentListController@EditSave');
			});
		});

		Route::group(['prefix' => 'main'] , function(){
			Route::group(['prefix' => 'employ'] , function(){
				Route::get('/' , 'ContractorEmployMainController@Index');
				Route::post('create' , 'ContractorEmployMainController@CreateSave');
			});

			Route::group(['prefix' => 'recurit'] , function(){
					Route::get('/' , 'RecuritReportMainRecuritController@Index');
					Route::get('pdf/{month}/{quater}' , 'RecuritReportMainRecuritController@ExportPDF')->name('recurit.report.main.recurit.export.pdf'); 
					Route::get('excel/{month}/{quater}' , 'RecuritReportMainRecuritController@ExportExcel')->name('recurit.report.main.recurit.export.excel'); 
			});

			Route::group(['prefix' => 'resign'] , function(){
					Route::get('/' , 'ContractorMainResignController@Index');
					Route::get('pdf' , 'ContractorMainResignController@ExportPDF')->name('contractor.main.resign.export.pdf'); 
			});
			Route::group(['prefix' => 'cancel'] , function(){
					Route::get('/' , 'ContractorMainCancelController@Index');
					Route::get('pdf' , 'ContractorMainCancelController@ExportPDF')->name('contractor.main.cancel.export.pdf'); 
			});
		});

		Route::group(['prefix' => 'department'] , function(){
			Route::group(['prefix' => 'recurit'] , function(){
					Route::get('/' , 'ContractorDepartmentRecuritController@Index');
					Route::get('pdf/{month}/{quater}' , 'ContractorDepartmentRecuritController@ExportPDF')->name('contractorr.department.recurit.export.pdf'); 
					Route::get('excel/{month}/{quater}' , 'ContractorDepartmentRecuritController@ExportExcel')->name('contractorr.department.recurit.export.excel'); 
			});
			Route::group(['prefix' => 'resign'] , function(){
					Route::get('/' , 'ContractorDepartmentResignController@Index');
					Route::get('pdf' , 'ContractorDepartmentResignController@ExportPDF')->name('contractor.department.resign.export.pdf'); 
			});
			Route::group(['prefix' => 'cancel'] , function(){
					Route::get('/' , 'ContractorDepartmentCancelController@Index');
					Route::get('pdf' , 'ContractorDepartmentCancelController@ExportPDF')->name('contractor.department.cancel.export.pdf'); 
			});			
		});

		Route::group(['prefix' => 'hire'] , function(){
				Route::get('/' , 'ContractorHireController@Index');
				Route::get('create/{id}' , 'ContractorHireController@Create');
				Route::get('createsave/{id}' , 'ContractorHireController@CreateSave');
				Route::get('view/{id}' , 'ContractorHireController@View');
		});

		Route::group(['prefix' => 'resign'] , function(){
				Route::get('/' , 'ContractorResignController@Index');
				Route::get('create' , 'ContractorResignController@Create');
				Route::post('create' , 'ContractorResignController@CreateSave');
				Route::get('delete/{id}' , 'ContractorResignController@DeleteSave');
		});
		Route::group(['prefix' => 'cancel'] , function(){
				Route::get('/' , 'ContractorCancelController@Index');
				Route::get('create' , 'ContractorCancelController@Create');
				Route::post('create' , 'ContractorCancelController@CreateSave');
				Route::get('delete/{id}' , 'ContractorCancelController@DeleteSave');
		});


		Route::group(['prefix' => 'refund'] , function(){

			Route::get('/' , 'ContractorRefundController@Index');
			Route::get('confirm/{id}' , 'ContractorRefundController@Confirm');
			Route::get('confirmanual/{id}' , 'ContractorRefundController@ConfirmAnual');
		});

	});	


	Route::group(['prefix' => 'transfer'] , function(){
		// Route::get('/' , 'TransferController@Index');
		Route::get('list' , 'TransferController@TransferList');
		Route::get('create' , 'TransferController@Create');
		Route::post('create' , 'TransferController@CreateSave');
		Route::get('edit/{id}' , 'TransferController@Edit');
		Route::post('edit' , 'TransferController@EditSave');
		Route::get('view/{id}' , 'TransferController@View');
		Route::get('delete/{id}' , 'TransferController@DeleteSave');
		Route::post('attach' , 'TransferController@AttachSave');
		Route::get('deletefile/{id}' , 'TransferController@DeleteFile');

		Route::group(['prefix' => 'department'] , function(){
			Route::get('/' , 'TransferDepartmentController@Index');
			Route::get('create' , 'TransferDepartmentController@Create');
			Route::post('create' , 'TransferDepartmentController@CreateSave');
			Route::get('view/{id}' , 'TransferDepartmentController@View');
			Route::get('edit/{id}' , 'TransferDepartmentController@Edit');
			Route::post('edit' , 'TransferDepartmentController@EditSave');
			Route::get('delete/{id}' , 'TransferDepartmentController@DeleteSave');
			Route::post('attach' , 'TransferDepartmentController@AttachSave');
			Route::get('deletefile/{id}' , 'TransferDepartmentController@DeleteFile');
		
		});

	});

	Route::group(['prefix' => 'project'] , function(){

		Route::group(['prefix' => 'refund'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ProjectRefundController@index')->name('project.refund');
				Route::get('edit/{id}/{sum}' , 'ProjectRefundController@Edit'); 
				Route::post('save/{id}' , 'ProjectRefundController@EditSave')->name('project.refund.save');; // action project edit
				Route::get('confirm/{id}' , 'ProjectRefundController@Confirm'); 
				Route::get('view' , 'ProjectRefundController@View')->name('project.refund.view'); 
			});
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ProjectRefundDepartmentController@index');
			});
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'ProjectRefundSectionController@index');
			});
		});

		Route::group(['prefix' => 'summary'] , function(){
			Route::get('/' , 'ProjectSummaryController@Index');
		});

		Route::group(['prefix' => 'allocation'] , function(){
			Route::get('/','ProjectAllocationController@Index'); //page project 
			Route::get('create' , 'ProjectAllocationController@Create'); // page project create
			Route::post('create' , 'ProjectAllocationController@CreateSave'); // action project create
			Route::get('edit/{id}' , 'ProjectAllocationController@Edit'); // page project edit
			Route::post('edit' , 'ProjectAllocationController@EditSave'); // action project edit
			Route::get('delete/{id}' , 'ProjectAllocationController@DeleteSave'); // action project delete
			Route::get('deptalllocate/{id}' , 'ProjectAllocationController@Deptalllocate'); // page project deptalllocate
			Route::post('deptalllocate' , 'ProjectAllocationController@DeptalllocateSave'); // action project deptalllocate
			Route::get('locate/{id}' , 'ProjectAllocationController@Locate'); // page project locate
			Route::post('locate' , 'ProjectAllocationController@LocateSave'); // action project locate

			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ProjectAllocationDepartmentController@Index');
				Route::get('view/{budget_id}' , 'ProjectAllocationDepartmentController@View');
				Route::get('create' , 'ProjectAllocationDepartmentController@Create');
				Route::post('create' , 'ProjectAllocationDepartmentController@CreateSave');
				Route::get('list' , 'ProjectAllocationDepartmentController@Lists');
				Route::get('list' , 'ProjectAllocationDepartmentController@Lists');
				Route::group(['prefix' => 'readiness'] , function(){
					Route::get('/' , 'ProjectAllocationDepartmentReadiness@Index');
					Route::post('create' , 'ProjectAllocationDepartmentReadiness@CreateSave');
				});
				Route::group(['prefix' => 'occupation'] , function(){
					Route::get('/' , 'ProjectAllocationDepartmentOccupation@Index');
					Route::post('create' , 'ProjectAllocationDepartmentOccupation@CreateSave');
				});

			});

			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'ProjectAllocationSectionController@Lists');
				Route::get('view/{id}' , 'ProjectAllocationSectionController@View');
			});
		});

		Route::group(['prefix' => 'report'] , function(){
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ProjectReportDepartmentController@Index');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ProjectReportDepartmentController@ExportExcel')->name('project.report.department.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ProjectReportDepartmentController@ExportPDF')->name('project.report.department.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ProjectReportDepartmentController@ExportWord')->name('project.report.department.export.word');
			});
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ProjectReportMainController@Index');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ProjectReportMainController@ExportExcel')->name('project.report.main.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ProjectReportMainController@ExportPDF')->name('project.report.main.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ProjectReportMainController@ExportWord')->name('project.report.main.export.word');
			});
		});

	});

	Route::group(['prefix' => 'report'] , function(){

		Route::group(['prefix' => 'recurit'] , function(){

			Route::group(['prefix' => 'department'] , function(){

				Route::group(['prefix' => 'allocation'] , function(){
					Route::get('/' , 'ReportRecuriteDepartmentController@Index');
					Route::get('excel/{month}/{quater}' , 'ReportRecuriteDepartmentController@ExportExcel')->name('allocation.export.excel');
					Route::get('pdf/{month}/{quater}' , 'ReportRecuriteDepartmentController@ExportPDF')->name('allocation.export.pdf');
					Route::get('word/{month}/{quater}' , 'ReportRecuriteDepartmentController@ExportWORD')->name('allocation.export.word');
				});
				Route::group(['prefix' => 'budget'] , function(){
					Route::get('/' , 'ReportRecuriteBudgetDepartmentController@Index');
					Route::get('excel/{month}/{quater}/{setyear}' , 'ReportRecuriteBudgetDepartmentController@ExportExcel')->name('budget.export.excel');
					Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportRecuriteBudgetDepartmentController@ExportPDF')->name('budget.export.pdf');
					Route::get('word/{month}/{quater}/{setyear}' , 'ReportRecuriteBudgetDepartmentController@ExportWORD')->name('budget.export.word');
				});

				
			});

			Route::group(['prefix' => 'main'] , function(){
				Route::group(['prefix' => 'allocation'] , function(){
					Route::get('/' , 'ReportRecuriteMainController@Index');
					Route::get('excel/{month}/{quater}' , 'ReportRecuriteMainController@ExportExcel')->name('main.allocation.export.excel');
					Route::get('pdf/{month}/{quater}' , 'ReportRecuriteMainController@ExportPDF')->name('main.allocation.export.pdf');
					Route::get('word/{month}/{quater}' , 'ReportRecuriteMainController@ExportWORD')->name('main.allocation.export.word');
				});
				Route::group(['prefix' => 'budget'] , function(){
					Route::get('/' , 'ReportRecuriteBudgetMainController@Index');
					Route::get('excel/{month}/{quater}' , 'ReportRecuriteBudgetMainController@ExportExcel')->name('main.budget.export.excel');
					Route::get('pdf/{month}/{quater}' , 'ReportRecuriteBudgetMainController@ExportPDF')->name('main.budget.export.pdf');
					Route::get('word/{month}/{quater}' , 'ReportRecuriteBudgetMainController@ExportWORD')->name('main.budget.export.word');
				});

			});



		});

		Route::group(['prefix' => 'readiness'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ReportReadinessMainController@Index');
				Route::get('readinesschart/' , 'ReportReadinessMainController@ReadinessChart');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportReadinessMainController@ExportExcel')->name('main.readiness.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportReadinessMainController@ExportPDF')->name('main.readiness.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportReadinessMainController@ExportWORD')->name('main.readiness.export.word');
			});
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ReportReadinessDepartmentController@Index');
				Route::get('readinesschart' , 'ReportReadinessDepartmentController@ReadinessChart');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportReadinessDepartmentController@ExportExcel')->name('readiness.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportReadinessDepartmentController@ExportPDF')->name('readiness.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportReadinessDepartmentController@ExportWORD')->name('readiness.export.word');
				Route::get('pdf/{id}' , 'ReportReadinessDepartmentController@ExportSinglePDF')->name('readiness.export.singlepdf');
			});

			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'ReportReadinessSectionController@Index');
				Route::get('pdf/{id}' , 'ReportReadinessSectionController@ExportSinglePDF');
				Route::group(['prefix' => 'participate'] , function(){
					Route::get('/{id}' , 'ReportReadinessSectionParticipateController@Index');
					Route::get('pdf/{id}' , 'ReportReadinessSectionParticipateController@ExportPDF');
					Route::get('excel/{id}' , 'ReportReadinessSectionParticipateController@ExportExcel');
				});
			});

		});

		Route::group(['prefix' => 'assessment'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ReportAssessmentMainController@Index');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportAssessmentMainController@ExportExcel')->name('assessment.main.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportAssessmentMainController@ExportPDF')->name('assessment.main.export.pdf');
			});
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ReportAssessmentDepartmentController@Index');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportAssessmentDepartmentController@ExportExcel')->name('assessment.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportAssessmentDepartmentController@ExportPDF')->name('assessment.export.pdf');
			});
			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'ReportAssessmentSectionController@Index');
				Route::get('view/{id}' , 'ReportAssessmentSectionController@View');
				Route::get('excel/{id}' , 'ReportAssessmentSectionController@ExportExcel');
				Route::get('pdf/{id}' , 'ReportAssessmentSectionController@ExportPDF');
			});

		});
		Route::group(['prefix' => 'information'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ReportInformationMainController@Index');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportInformationMainController@ExportExcel')->name('information.main.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportInformationMainController@ExportPDF')->name('information.main.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportInformationMainController@ExportWORD')->name('information.main.export.word');
			});
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ReportInformationDepartmentController@Index');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportInformationDepartmentController@ExportExcel')->name('information.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportInformationDepartmentController@ExportPDF')->name('information.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportInformationDepartmentController@ExportWORD')->name('information.export.word');
			});

		});				

		Route::group(['prefix' => 'followup'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::group(['prefix' => 'hasoccupation'] , function(){
					Route::get('/' , 'ReportFollowupMainHasoccupationController@Index');
					Route::get('hasoccupationchart' , 'ReportFollowupMainHasoccupationController@HasOccupationChart');
					Route::get('excel/{month}/{quater}/{setyear}' , 'ReportFollowupMainHasoccupationController@ExportExcel')->name('followup.hasoccupation.export.excel');
					Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportFollowupMainHasoccupationController@ExportPDF')->name('followup.hasoccupation.export.pdf');
					Route::get('word/{month}/{quater}/{setyear}' , 'ReportFollowupMainHasoccupationController@ExportWORD')->name('followup.hasoccupation.export.word');
				});
				Route::group(['prefix' => 'enoughincome'] , function(){
					Route::get('/' , 'ReportFollowupMainEnoughIncomeController@Index');
					Route::get('enoughincomechart' , 'ReportFollowupMainEnoughIncomeController@EnoughIncomeChart');
					Route::get('excel/{month}/{quater}' , 'ReportFollowupMainEnoughIncomeController@ExportExcel')->name('followup.enoughincome.export.excel');
					Route::get('pdf/{month}/{quater}' , 'ReportFollowupMainEnoughIncomeController@ExportPDF')->name('followup.enoughincome.export.pdf');
					Route::get('word/{month}/{quater}' , 'ReportFollowupMainEnoughIncomeController@ExportWORD')->name('followup.enoughincome.export.word');
				});

					Route::group(['prefix' => 'onsite'] , function(){
					Route::get('/' , 'ReportFollowupOnsiteMainController@Index');
					Route::get('pdf/{id}' , 'ReportFollowupOnsiteMainController@ExportPDF');
					Route::get('excel/{id}' , 'ReportFollowupOnsiteMainController@ExportExcel');
					Route::get('view/{id}' , 'ReportFollowupOnsiteMainController@View');

				});

			});
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ReportFollowupDepartmentController@Index');
				Route::get('hasoccupationchart' , 'ReportFollowupDepartmentController@OccupationChart');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportFollowupDepartmentController@ExportExcel')->name('followup.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportFollowupDepartmentController@ExportPDF')->name('followup.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportFollowupDepartmentController@ExportWORD')->name('followup.export.word');
				Route::group(['prefix' => 'enoughexpense'] , function(){
					Route::get('/' , 'ReportFollowupEnoughExpenseDepartmentController@Index');
					Route::get('hasoccupationchart' , 'ReportFollowupEnoughExpenseDepartmentController@OccupationChart');
					Route::get('excel/{month}/{quater}/{setyear}' , 'ReportFollowupEnoughExpenseDepartmentController@ExportExcel')->name('followupenoughexpense.export.excel');
					Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportFollowupEnoughExpenseDepartmentController@ExportPDF')->name('followupenoughexpense.export.pdf');
					Route::get('word/{month}/{quater}/{setyear}' , 'ReportFollowupEnoughExpenseDepartmentController@ExportWORD')->name('followupenoughexpense.export.word');
				});

				Route::group(['prefix' => 'onsite'] , function(){
					Route::get('/' , 'ReportFollowupOnsiteDepartmentController@Index');
					Route::get('pdf/{id}' , 'ReportFollowupOnsiteDepartmentController@ExportPDF');
					Route::get('excel/{id}' , 'ReportFollowupOnsiteDepartmentController@ExportExcel');
					Route::get('view/{id}' , 'ReportFollowupOnsiteDepartmentController@View');

				});
			});

		});

		Route::group(['prefix' => 'occupation'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ReportOccupationMainController@Index');
				Route::get('occupationchart' , 'ReportOccupationMainController@OccupationChart');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportOccupationMainController@ExportExcel')->name('main.occupation.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportOccupationMainController@ExportPDF')->name('main.occupation.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportOccupationMainController@ExportWORD')->name('main.occupation.export.word');
				Route::group(['prefix' => 'expense'] , function(){
					Route::get('/' , 'ReportOccupationMainExpenseController@Index');
					Route::get('pdf' , 'ReportOccupationMainExpenseController@ExportPDF');
					Route::get('excel' , 'ReportOccupationMainExpenseController@ExportExcel');
				});
			});

			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ReportOccupationDepartmentController@Index');
				Route::get('occupationchart' , 'ReportOccupationDepartmentController@OccupationChart');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportOccupationDepartmentController@ExportExcel')->name('occupation.export.excel');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportOccupationDepartmentController@ExportPDF')->name('occupation.export.pdf');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportOccupationDepartmentController@ExportWORD')->name('occupation.export.word');
				Route::get('pdf/{id}' , 'ReportOccupationDepartmentController@ExportSinglePDF')->name('occupation.export.singlepdf');
				Route::group(['prefix' => 'participate'] , function(){
					Route::get('/{id}' , 'ReportOccupationDepartmentParticipateController@Index');
					Route::get('pdf/{id}' , 'ReportOccupationDepartmentParticipateController@ExportPDF');
					Route::get('excel/{id}' , 'ReportOccupationDepartmentParticipateController@ExportExcel');
				});
				Route::group(['prefix' => 'expense'] , function(){
					Route::get('/' , 'ReportOccupationDepartmentExpenseController@Index');
					Route::get('pdf' , 'ReportOccupationDepartmentExpenseController@ExportPDF');
					Route::get('excel' , 'ReportOccupationDepartmentExpenseController@ExportExcel');
				});
			});

			Route::group(['prefix' => 'section'] , function(){
				Route::get('/' , 'ReportOccupationSectionController@Index');
				Route::get('pdf/{id}' , 'ReportOccupationSectionController@ExportSinglePDF');
				Route::group(['prefix' => 'participate'] , function(){
					Route::get('/{id}' , 'ReportOccupationSectionParticipateController@Index');
					Route::get('pdf/{id}' , 'ReportOccupationSectionParticipateController@ExportPDF');
					Route::get('excel/{id}' , 'ReportOccupationSectionParticipateController@ExportExcel');
				});
			});



		});

		Route::group(['prefix' => 'refund'] , function(){
			Route::group(['prefix' => 'main'] , function(){
				Route::get('/' , 'ReportRefundMainController@Index');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportRefundMainController@ExportPDF')->name('refund.export.main.pdf');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportRefundMainController@ExportExcel')->name('refund.export.main.excel');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportRefundMainController@ExportWord')->name('refund.export.main.word');
			});
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'ReportRefundDepartment@Index');
				Route::get('pdf/{month}/{quater}/{setyear}' , 'ReportRefundDepartment@ExportPDF')->name('refund.export.pdf');
				Route::get('excel/{month}/{quater}/{setyear}' , 'ReportRefundDepartment@ExportExcel')->name('refund.export.excel');
				Route::get('word/{month}/{quater}/{setyear}' , 'ReportRefundDepartment@ExportWord')->name('refund.export.word');
			});

		});
	
	});


	Route::group(['prefix' => 'setting'] , function(){

		Route::group(['prefix' => 'log'] , function(){
			Route::get('' , 'LogController@Index'); 
		});

		Route::group(['prefix' => 'backup'] , function(){
			Route::get('' , 'BackupController@Index'); 
			Route::get('backup' , 'BackupController@Backup'); 
			Route::get('edit' , 'BackupController@Edit');
			Route::post('edit' , 'BackupController@EditSave');
		});

		Route::group(['prefix' => 'year'] , function(){
			Route::get('/' , 'SettingYearController@Index');
			Route::get('create' , 'SettingYearController@Create');
			Route::post('create' , 'SettingYearController@CreateSave');
			Route::post('selectyear' , 'SettingYearController@SelectYear');
			Route::get('delete/{id}' , 'SettingYearController@Delete');

			Route::group(['prefix' => 'budget'] , function(){
				Route::get('/{id}' , 'SettingYearController@Budget');
				Route::post('/' , 'SettingYearController@BudgetSave');
			});

			Route::group(['prefix' => 'department'] , function(){
				Route::get('/{id}' , 'SettingYearController@Department');
				Route::post('/' , 'SettingYearController@DepartmentSave');
			});

		});
		Route::group(['prefix' => 'landing'] , function(){
			Route::get('/' , 'SettingLandingpictureController@Index');
			Route::post('edit' , 'SettingLandingpictureController@Edit');
			Route::get('delete-picture/{id}' , 'SettingLandingpictureController@DeletePicture');
			Route::get('create' , 'SettingLandingpictureController@Create');
			Route::post('create' , 'SettingLandingpictureController@CreateSave');
			Route::get('delete/{id}' , 'SettingLandingpictureController@DeleteDoc');
			Route::get('editdoc/{id}' , 'SettingLandingpictureController@EditDoc');
			Route::post('editdocsave' , 'SettingLandingpictureController@EditDocSave');

		});
		Route::group(['prefix' => 'contractorposition'] , function(){
			Route::get('/' , 'SettingContractorPositionController@Index');
			Route::get('create' , 'SettingContractorPositionController@Create');
			Route::post('create' , 'SettingContractorPositionController@CreateSave');
			Route::get('edit/{id}' , 'SettingContractorPositionController@Edit');
			Route::post('edit' , 'SettingContractorPositionController@EditSave');
			Route::get('delete/{id}' , 'SettingContractorPositionController@Delete');
		});

		Route::group(['prefix' => 'budget'] , function(){
			Route::get('/' , 'SettingBudgetController@Index');
			Route::get('create' , 'SettingBudgetController@Create');
			Route::post('create' , 'SettingBudgetController@CreateSave');
			Route::get('edit/{id}' , 'SettingBudgetController@Edit');
			Route::post('edit' , 'SettingBudgetController@EditSave');
			Route::get('delete/{id}' , 'SettingBudgetController@DeleteSave');
		});

		Route::group(['prefix' => 'department'] , function(){
			Route::get('/' , 'SettingDepartmentController@Index');
			Route::get('create' , 'SettingDepartmentController@Create');
			Route::post('create' , 'SettingDepartmentController@CreateSave');
			Route::get('edit/{id}' , 'SettingDepartmentController@Edit');
			Route::post('edit' , 'SettingDepartmentController@EditSave');
			Route::get('delete/{id}' , 'SettingDepartmentController@DeleteSave');
		});

		Route::group(['prefix' => 'section'] , function(){
			Route::get('/' , 'SettingSectionController@Index');
			Route::get('create' , 'SettingSectionController@Create');
			Route::post('create' , 'SettingSectionController@CreateSave');
			Route::get('edit/{id}' , 'SettingSectionController@Edit');
			Route::post('edit' , 'SettingSectionController@EditSave');
			Route::get('delete/{id}' , 'SettingSectionController@DeleteSave');
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'SettingSectionDepartmentController@Index');
				Route::get('create' , 'SettingSectionDepartmentController@Create');
				Route::post('create' , 'SettingSectionDepartmentController@CreateSave');
				Route::get('edit/{id}' , 'SettingSectionDepartmentController@Edit');
				Route::post('edit' , 'SettingSectionDepartmentController@EditSave');
				Route::get('delete/{id}' , 'SettingSectionDepartmentController@DeleteSave');
			});

		});

		Route::group(['prefix' => 'position'] , function(){
			Route::get('/' , 'SettingPositionController@Index');
			Route::get('create' , 'SettingPositionController@Create');
			Route::post('create' , 'SettingPositionController@CreateSave');
			Route::get('edit/{id}' , 'SettingPositionController@Edit');
			Route::post('edit' , 'SettingPositionController@EditSave');
			Route::get('delete/{id}' , 'SettingPositionController@DeleteSave');
			Route::group(['prefix' => 'department'] , function(){
				Route::get('/' , 'SettingPositionDepartmentController@Index');
				Route::get('create' , 'SettingPositionDepartmentController@Create');
				Route::post('create' , 'SettingPositionDepartmentController@CreateSave');
				Route::get('delete/{id}' , 'SettingPositionDepartmentController@DeleteSave');
				Route::get('edit/{id}' , 'SettingPositionDepartmentController@Edit');
				Route::post('edit' , 'SettingPositionDepartmentController@EditSave');
				Route::get('delete/{id}' , 'SettingPositionDepartmentController@DeleteSave');
			});
		});
			Route::group(['prefix' => 'user'], function (){
			Route::get('/','UsersController@Index');
			Route::get('create' , 'UsersController@Create');
			Route::post('create' , 'UsersController@CreateSave');
			Route::get('edit/{id}' , 'UsersController@Edit');
			Route::post('edit' , 'UsersController@EditSave');
			Route::get('delete/{id}' , 'UsersController@Delete');


			Route::group(['prefix' => 'profile'], function (){		
				Route::get('/' , 'UserProfileController@Index');
				Route::post('edit' , 'UserProfileController@Edit');
				Route::get('makeread/{id}' , 'UserProfileController@Makeread');
				Route::get('deletemessage/{id}' , 'UserProfileController@Deletemessage');
				Route::get('makereadall' , 'UserProfileController@MakereadAll');
				Route::get('deleteall' , 'UserProfileController@DeleteAll');
			});

		});

		Route::group(['prefix' => 'webapi'] , function(){
				Route::get('/' , 'SettingWebApiController@Index');
				Route::get('edit/{id}' , 'SettingWebApiController@Edit');
				Route::post('edit' , 'SettingWebApiController@EditSave');
		});
		Route::group(['prefix' => 'generalsetting'] , function(){
				Route::get('/' , 'SettingGeneralController@Index');
				Route::get('onlinereg' , 'SettingGeneralController@SelectOnlineReg');
		});


	});

});
