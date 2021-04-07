<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use DB;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [  
        'name',
        'email',
        'phone',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
        'is_phone_verified',
        'status',
        'device_token',
        'isd_code',
        'last_login',
        'total_login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function role_user(){
        return $this->hasMany('App\RoleUser');
    }

    public function course_attempts(){
        return $this->hasMany('App\CourseAttempt');
    }

    public function user_image(){
        return $this->hasOne('App\UserImage');
    }

    public function image_upload(){
        return $this->hasOne('App\ImageUpload');
    }

    public function designs(){
        return $this->hasMany('App\Design');
    }

    public function portfolio(){
        return $this->hasMany('App\Portfolio');
    }

    public function proposal(){
        return $this->hasMany('App\Proposal');
    }

    public function proposal_images(){
        return $this->hasMany('App\ProposalImage');
    }
    
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    
    public function first_proposal(){
        return $this->hasMany('App\FirstProposal');
    }

    public function second_proposal(){
        return $this->hasMany('App\SecondProposal');
    }

    public function third_proposal(){
        return $this->hasMany('App\ThirdProposal');
    }

    public function admin_propsal(){
        return $this->hasMany('App\AdminProposal');
    }

    public function admin_propsal_files(){
        return $this->hasMany('App\AdminProposalFile');
    }

    public function bank_detail(){
        return $this->hasOne('App\BankDetail');
    }

    public function manual_payment(){
        return $this->hasMany('App\ManualPayment');
    }

    public function stripe_token(){
        return $this->hasMany('App\StripeToken');
    }

    public function stripe_payment(){
        return $this->hasMany('App\StripePayment');
    }

    public static function laratablesCustomRoles($user)
    {
        return view('admin.users.roles', compact('user'))->render();
    }

    public function hasRole( $role ) {
        $roles =  array_column($this->roles->toArray(), 'title');
        $roles = array_map('strtolower', $roles);
        return ( in_array($role, $roles) ) ? true : false ;
    }

    public static function laratablesCustomAction($user)
    {
        return view('admin.users.action', compact('user'))->render();
    }

    public static function laratablesStatus($user)
    {
        return $user->status == 1 ? trans('global.active') : trans('global.inactive');
    }
    
    public static function update_user($input, $where){
        $query = User::where($where);
        if($query->update($input)) {    
            return 'true';
        } else {
            return 'false';
        }
    }

    public static function laratablesRowClass($user)
    {
        return $user->status=='1' ? 'text-dark' : 'text-danger';
    }


        /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }   

}
