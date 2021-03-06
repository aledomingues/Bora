<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model {

	protected $table = 'company_types';
	protected $primaryKey = 'id_company_types';
	protected $fillable = ['type'];
	protected $hidden = ['deleted_at', 'updated_at', 'created_at'];
	protected $softDelete = true;
	public $timestamps = true;

	public function company(){
		return $this->hasMany('App\Models\Company', 'id_company_types', 'id_company_types');
	}
}
