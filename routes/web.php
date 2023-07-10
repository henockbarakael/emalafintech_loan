<?php

use App\Http\Middleware\CloseCashRegisterMiddleware;
use App\Http\Middleware\OpenCashRegisterMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');

Route::group(['prefix'=>'admin', 'middleware'=>['admin','auth','PreventBackHistory']], function(){

    // Route::middleware([OpenCashRegisterMiddleware::class])->group(function () {
    //     Route::get('/open-cash-register', [CashRegisterController::class, 'showCloseCashRegisterForm'])->name('admin.showCloseCashRegisterForm');
    //     Route::post('/open-cash-register', [CashRegisterController::class, 'closeCashRegister'])->name('admin.closeCashRegister');
    // });

    // Route::middleware([CloseCashRegisterMiddleware::class])->group(function () {
    //     Route::get('/close-cash-register', [CashRegisterController::class, 'showCloseCashRegisterForm'])->name('admin.showCloseCashRegisterForm');
    //     Route::post('/close-cash-register', [CashRegisterController::class, 'closeCashRegister'])->name('admin.closeCashRegister');
    // });

    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin.dashboard');
    Route::get('transaction', [App\Http\Controllers\Backend\Admin\TransactionController::class, 'all'])->name('admin.transaction.all');
    Route::get('transaction-deposit', [App\Http\Controllers\Backend\Admin\TransactionController::class, 'deposit'])->name('admin.transaction.deposit');
    Route::get('transaction-transfer', [App\Http\Controllers\Backend\Admin\TransactionController::class, 'transfer'])->name('admin.transaction.transfer');
    Route::get('transaction-withdrawal', [App\Http\Controllers\Backend\Admin\TransactionController::class, 'withdrawal'])->name('admin.transaction.withdrawal');
    Route::post('transaction', [App\Http\Controllers\Backend\Admin\TransactionController::class, 'search'])->name('admin.transaction.search');

    Route::get('customer', [App\Http\Controllers\Backend\CustomerController::class, 'index'])->name('admin.customer.all');
    Route::post('customer', [App\Http\Controllers\Backend\CustomerController::class, 'add'])->name('admin.customer.add');
    Route::post('customer-edit', [App\Http\Controllers\Backend\CustomerController::class, 'edit'])->name('admin.customer.edit');
    Route::post('customer-delete', [App\Http\Controllers\Backend\CustomerController::class, 'delete'])->name('admin.customer.delete');

    Route::get('user', [App\Http\Controllers\Backend\Admin\UserController::class, 'index'])->name('admin.user.all');
    Route::post('user', [App\Http\Controllers\Backend\Admin\UserController::class, 'add'])->name('admin.user.add');
    Route::post('user-edit', [App\Http\Controllers\Backend\Admin\UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('user-delete', [App\Http\Controllers\Backend\Admin\UserController::class, 'delete'])->name('admin.user.delete');

    Route::get('branch', [App\Http\Controllers\Backend\Admin\BranchController::class, 'index'])->name('admin.branch.all');
    Route::post('branch', [App\Http\Controllers\Backend\Admin\BranchController::class, 'add'])->name('admin.branch.add');
    Route::post('branch-edit', [App\Http\Controllers\Backend\Admin\BranchController::class, 'edit'])->name('admin.branch.edit');
    Route::post('branch-delete', [App\Http\Controllers\Backend\Admin\BranchController::class, 'delete'])->name('admin.branch.delete');
    Route::post('branch-topup', [App\Http\Controllers\Backend\Admin\BranchController::class, 'topup'])->name('admin.branch.topup');

    Route::get('wallet-agence', [App\Http\Controllers\Backend\Admin\WalletController::class, 'agence'])->name('admin.wallet.agence');
    Route::post('wallet-agence', [App\Http\Controllers\Backend\Admin\WalletController::class, 'walletAgenceAdd'])->name('admin.wallet-agence.add');
    Route::post('wallet-agence-edit', [App\Http\Controllers\Backend\Admin\WalletController::class, 'walletAgenceEdit'])->name('admin.wallet-agence.edit');
    Route::post('wallet-agence-delete', [App\Http\Controllers\Backend\Admin\WalletController::class, 'walletAgenceDelete'])->name('admin.wallet-agence.delete');
    Route::post('wallet-agence-topup', [App\Http\Controllers\Backend\Admin\WalletController::class, 'walletAgenceTopup'])->name('admin.wallet-agence.topup');

    Route::get('wallet-emala', [App\Http\Controllers\Backend\Admin\WalletController::class, 'emala'])->name('admin.wallet.emala');
    Route::post('wallet-emala', [App\Http\Controllers\Backend\Admin\WalletController::class, 'walletEmalaEdit'])->name('admin.wallet-emala.edit');
    Route::post('wallet-emala-topup', [App\Http\Controllers\Backend\Admin\WalletController::class, 'walletEmalaTopup'])->name('admin.wallet-emala.topup');
    Route::post('wallet-emala-delete', [App\Http\Controllers\Backend\Admin\WalletController::class, 'walletEmalaDelete'])->name('admin.wallet-emala.delete');

    Route::get('demande-de-recharge', [App\Http\Controllers\Backend\Admin\RechargeRequestController::class, 'index'])->name('admin.recharge.request');
    Route::post('demande-de-recharge', [App\Http\Controllers\Backend\Admin\RechargeRequestController::class, 'respondRequest'])->name('admin.recharge.process');

    Route::get('compte-client/{id}', [App\Http\Controllers\Backend\Admin\AccountController::class, 'client'])->name('admin.customer.account');
    Route::get('compte-client-phone/{id}', [App\Http\Controllers\Backend\Admin\AccountController::class, 'clientPhone'])->name('admin.customer.account.phone');

    Route::get('depot/cash/{id}', [App\Http\Controllers\Backend\Admin\AccountController::class, 'client_depot'])->name('admin.customer.depot');
    Route::post('depot/cash', [App\Http\Controllers\Backend\Admin\AccountController::class, 'client_depot_save'])->name('admin.customer.depot.save');

    Route::get('retrait/cash/{id}', [App\Http\Controllers\Backend\Admin\AccountController::class, 'client_retrait'])->name('admin.customer.retrait');
    Route::post('retrait/cash', [App\Http\Controllers\Backend\Admin\AccountController::class, 'client_retrait_save'])->name('admin.customer.retrait.save');

    Route::get('transfert/interne/{id}', [App\Http\Controllers\Backend\Admin\AccountController::class, 'client_transfert'])->name('admin.customer.transfert');
    Route::post('transfert/interne', [App\Http\Controllers\Backend\Admin\AccountController::class, 'client_transfert_save'])->name('admin.customer.transfert.save');

    Route::get('pret-bancaire/interne/{id}', [App\Http\Controllers\Backend\Admin\AccountController::class, 'pret'])->name('admin.customer.pret');
    Route::get('pret-demande', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'demande'])->name('admin.pret.demande');
    Route::post('pret-demande', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'demandePost'])->name('admin.pret.demande.post');
    Route::post('approuver-demande', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'approuver'])->name('admin.demande.success');
    Route::post('desapprouver-demande', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'desapprouver'])->name('admin.demande.failed');

    Route::get('pret-amortissement', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'amortissement'])->name('admin.pret.amortissement');

    Route::get('pret-type', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'type'])->name('admin.pret.type');
    Route::post('pret-type', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'typePost'])->name('admin.pret.type.post');
    Route::post('pret-type-edit', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'typeEdit'])->name('admin.pret.type.edit');
    Route::post('pret-type-delete', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'typeDelete'])->name('admin.pret.type.delete');

    Route::get('pret-plan', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'plan'])->name('admin.pret.plan');
    Route::post('pret-plan', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'planPost'])->name('admin.pret.plan.post');
    Route::post('pret-plan-edit', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'planEdit'])->name('admin.pret.plan.edit');
    Route::post('pret-plan-delete', [App\Http\Controllers\Backend\Admin\PretBancaireController::class, 'planDelete'])->name('admin.pret.plan.delete');

});

Route::group(['prefix'=>'manager', 'middleware'=>['manager','auth','PreventBackHistory']], function(){

    // Route::get('/cash-register/open', [App\Http\Controllers\CashRegisterController::class, 'open'])->name('manager.cash-register.open');
    // Route::get('/cash-register/close', [App\Http\Controllers\CashRegisterController::class, 'close'])->name('manager.cash-register.close');

    // Route::middleware([CloseCashRegisterMiddleware::class])->group(function () {
    //     Route::get('/close-cash-register', [CashRegisterController::class, 'showCloseCashRegisterForm'])->name('manager.showCloseCashRegisterForm');
    //     Route::post('/close-cash-register', [CashRegisterController::class, 'closeCashRegister'])->name('manager.closeCashRegister');
    // });

    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'manager'])->name('manager.dashboard');
    Route::get('transaction', [App\Http\Controllers\Backend\Manager\TransactionController::class, 'all'])->name('manager.transaction.all');
    Route::get('transaction-deposit', [App\Http\Controllers\Backend\Manager\TransactionController::class, 'deposit'])->name('manager.transaction.deposit');
    Route::get('transaction-transfer', [App\Http\Controllers\Backend\Manager\TransactionController::class, 'transfer'])->name('manager.transaction.transfer');
    Route::get('transaction-withdrawal', [App\Http\Controllers\Backend\Manager\TransactionController::class, 'withdrawal'])->name('manager.transaction.withdrawal');
    Route::post('transaction', [App\Http\Controllers\Backend\Manager\TransactionController::class, 'search'])->name('manager.transaction.search');
    
    Route::get('customer', [App\Http\Controllers\Backend\Manager\CustomerController::class, 'index'])->name('manager.customer.all');
    Route::post('customer', [App\Http\Controllers\Backend\Manager\CustomerController::class, 'add'])->name('manager.customer.add');
    Route::post('customer-edit', [App\Http\Controllers\Backend\Manager\CustomerController::class, 'edit'])->name('manager.customer.edit');
    Route::post('customer-delete', [App\Http\Controllers\Backend\Manager\CustomerController::class, 'delete'])->name('manager.customer.delete');
    
    Route::get('user', [App\Http\Controllers\Backend\Manager\UserController::class, 'index'])->name('manager.user.all');
    Route::post('user', [App\Http\Controllers\Backend\Manager\UserController::class, 'add'])->name('manager.user.add');
    Route::post('user-edit', [App\Http\Controllers\Backend\Manager\UserController::class, 'edit'])->name('manager.user.edit');
    Route::post('user-delete', [App\Http\Controllers\Backend\Manager\UserController::class, 'delete'])->name('manager.user.delete');
    
    Route::get('wallet-agence', [App\Http\Controllers\Backend\Manager\WalletController::class, 'agence'])->name('manager.wallet.agence');
    Route::get('wallet-recharge-historique', [App\Http\Controllers\Backend\Manager\WalletController::class, 'historique'])->name('manager.wallet.recharge.historique');
    Route::post('wallet-recharge', [App\Http\Controllers\Backend\Manager\WalletController::class, 'recharge'])->name('manager.wallet.recharge');

    Route::get('compte-client/{id}', [App\Http\Controllers\Backend\Manager\AccountController::class, 'client'])->name('manager.customer.account');
    Route::get('compte-client-phone/{id}', [App\Http\Controllers\Backend\Manager\AccountController::class, 'clientPhone'])->name('manager.customer.account.phone');

    Route::get('depot/cash/{id}', [App\Http\Controllers\Backend\Manager\AccountController::class, 'client_depot'])->name('manager.customer.depot');
    Route::post('depot/cash', [App\Http\Controllers\Backend\Manager\AccountController::class, 'client_depot_save'])->name('manager.customer.depot.save');

    Route::get('retrait/cash/{id}', [App\Http\Controllers\Backend\Manager\AccountController::class, 'client_retrait'])->name('manager.customer.retrait');
    Route::post('retrait/cash', [App\Http\Controllers\Backend\Manager\AccountController::class, 'client_retrait_save'])->name('manager.customer.retrait.save');

    Route::get('transfert/interne/{id}', [App\Http\Controllers\Backend\Manager\AccountController::class, 'client_transfert'])->name('manager.customer.transfert');
    Route::post('transfert/interne', [App\Http\Controllers\Backend\Manager\AccountController::class, 'client_transfert_save'])->name('manager.customer.transfert.save');

    Route::get('pret-bancaire/interne/{id}', [App\Http\Controllers\Backend\Manager\AccountController::class, 'pret'])->name('manager.customer.pret');
    Route::get('pret-demande', [App\Http\Controllers\Backend\Manager\PretBancaireController::class, 'demande'])->name('manager.pret.demande');
    Route::post('pret-demande', [App\Http\Controllers\Backend\Manager\PretBancaireController::class, 'demandePost'])->name('manager.pret.demande.post');
    Route::get('pret-amortissement', [App\Http\Controllers\Backend\Manager\PretBancaireController::class, 'amortissement'])->name('manager.pret.amortissement');

    Route::get('remboursement-pret/{id}', [App\Http\Controllers\Backend\Manager\AccountController::class, 'remboursement'])->name('manager.customer.pret');
    Route::post('remboursement-pret', [App\Http\Controllers\Backend\Manager\PretBancaireController::class, 'remboursementPost'])->name('manager.customer.remboursement.post');


});

Route::group(['prefix'=>'cashier', 'middleware'=>['cashier','auth','PreventBackHistory']], function(){
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'cashier'])->name('cashier.dashboard');
    Route::get('transaction', [App\Http\Controllers\Backend\Cashier\TransactionController::class, 'all'])->name('cashier.transaction.all');
    Route::get('transaction-deposit', [App\Http\Controllers\Backend\Cashier\TransactionController::class, 'deposit'])->name('cashier.transaction.deposit');
    Route::get('transaction-transfer', [App\Http\Controllers\Backend\Cashier\TransactionController::class, 'transfer'])->name('cashier.transaction.transfer');
    Route::get('transaction-withdrawal', [App\Http\Controllers\Backend\Cashier\TransactionController::class, 'withdrawal'])->name('cashier.transaction.withdrawal');
    Route::post('transaction', [App\Http\Controllers\Backend\Cashier\TransactionController::class, 'search'])->name('cashier.transaction.search');
});

Route::group(['prefix'=>'customer', 'middleware'=>['customer','auth','PreventBackHistory']], function(){
    Route::get('dashboard', [App\Http\Controllers\Frontend\HomeController::class, 'customer'])->name('customer.dashboard');
});