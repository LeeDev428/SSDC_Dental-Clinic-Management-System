    <?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\UserController; // Add this import for UserController
    use App\Http\Controllers\AppointmentController;
    use App\Http\Controllers\InventoryController;
    use App\Http\Controllers\NotificationController;
    use App\Http\Controllers\AdminAppointment;
    use App\Http\Controllers\UserSettingsController;
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\AdminMessageController;
    use App\Http\Controllers\Auth\GoogleController;
    use App\Http\Controllers\ChartController;
    use App\Http\Controllers\ProcedurePriceController;

    use Illuminate\Http\Request;
    use Laravel\Socialite\Facades\Socialite;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Message;

    use Illuminate\Support\Facades\Route;

    use App\Http\Middleware\AdminMiddleware;
    use App\Http\Middleware\UserMiddleware; // Import UserMiddleware



    //default 8080
    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy'); // Updated for consistency 
        Route::post('/calculate-price', [AppointmentController::class, 'calculatePrice']);
        Route::get('appointments/check', [AppointmentController::class, 'check'])->name('appointments.check');
    });

    // Route for the user dashboard with UserMiddleware
    Route::middleware(UserMiddleware::class)->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard'); // Use UserController instead of ProfileController
        Route::get('/get-procedure-details', [UserController::class, 'getProcedureDetails']);
        Route::get('/admin/details', [UserController::class, 'getAdminDetails']);
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store'); 
          // In your routes/web.php
    Route::get('/admin/upcoming_appointments', [AdminController::class, 'showUpcomingAppointments']);
    Route::post('/appointments/{id}/action/{action}', [AppointmentController::class, 'handleAction'])->name('appointment.handleAction');   
    });



    //usersettings
    Route::middleware(UserMiddleware::class)->group(function () {
        Route::get('/usersettings', [UserSettingsController::class, 'index'])->name('usersettings');
    });

    // Routes for admin with AdminMiddleware
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/patient-management', [AdminController::class, 'patientmanagement'])->name('admin.patient-management'); 
    });
    //realtime notifications in admin
    Route::get('/notifications/unread-count', [AdminAppointment::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/pending-count', [AdminController::class, 'getPendingCount'])->name('notifications.pending-count');
    //realtime notifications in users
    Route::get('/notifications/unread-count', [AdminAppointment::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/fetch', [AdminAppointment::class, 'fetchNotifications'])->name('notifications.fetch');

  
    
    // Routes for admin with AdminMiddleware
    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/admin/pending-appointments', [AdminController::class, 'upcomingAppointments'])->name('admin.upcoming_appointments');
        Route::get('/admin/upcoming-appointments', [AdminController::class, 'acceptedAppointments'])->name('admin.appointments');
        
    //decline and accept in appoitnments
        Route::post('/appointments/{id}/accept', [AppointmentController::class, 'accept'])->name('appointments.accept');
        Route::post('/appointments/{id}/decline', [AppointmentController::class, 'decline'])->name('appointments.decline');
        Route::get('/admin/patient-information', [AdminController::class, 'patientInformation'])->name('admin.patient_information');
    //inventory
        Route::get('/admin/inventory-admin', [InventoryController::class, 'index'])->name('admin.inventory_admin');
        Route::put('/admin/inventory-admin/update/{id}', [InventoryController::class, 'update'])->name('admin.inventory_admin.update');
        Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('admin.inventory.update');
        Route::delete('/admin/inventory-admin/{id}', [InventoryController::class, 'destroy'])->name('admin.inventory_admin.destroy');
        
        Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('notification.show');
        Route::post('/appointment/{id}/{action}', [AdminAppointment::class, 'handleAction'])->name('appointment.handleAction');
                // This will ensure that the notification logic points to AdminAppointment controller
                Route::post('/notifications/mark-as-read', [AdminAppointment::class, 'markNotificationsAsRead']);
                Route::post('/notifications/accept-decline', [AdminAppointment::class, 'handleAction']);
                Route::post('/notification/{id}/read', [AdminAppointment::class, 'markAsRead'])->name('notification.read');
                Route::get('/notifications/unread/count', [AdminAppointment::class, 'getUnreadCount'])->name('notification.unreadCount');
    Route::post('/mark-notifications-as-read', [AdminAppointment::class, 'markAsRead']);

    Route::middleware(['auth'])->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAll');
        Route::post('/notifications/mark/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.mark');
        Route::post('/mark-notifications-as-read', [NotificationController::class, 'markAsRead']);
        Route::get('/get-unread-count', [NotificationController::class, 'getUnreadCount']);
        Route::post('/mark-notifications-as-read', [NotificationController::class, 'markAsRead']);
      

        //chat
        Route::get('/admin/messages', [AdminMessageController::class, 'index'])->name('admin.patient_messages');

        // Route to store admin responses
        Route::get('/messages/{user}', [AdminMessageController::class, 'showMessages'])->name('admin.messages.show');
        Route::get('/admin/messages', [AdminMessageController::class, 'index1'])->name('admin.messages');
    Route::post('/admin/messages', [AdminMessageController::class, 'store'])->name('admin.messages.store');
    Route::get('/admin/view-messages', [AdminMessageController::class, 'index'])->name('admin.patient_messages');
    });


    });


    // storing inventory
    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Route to show the inventory page
    Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory_admin.index');

    // Route to store new inventory items via AJAX
    Route::post('/admin/inventory', [InventoryController::class, 'store'])->name('admin.inventory_admin.store');
    Route::get('/admin/inventory-admin', [InventoryController::class, 'index'])->name('admin.inventory_admin');
    Route::get('/appointments-chart', [ChartController::class, 'index']);
    
    });
    
    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        // Existing routes for inventory and procedure prices
        Route::get('/admin/procedure-prices', [ProcedurePriceController::class, 'index'])->name('admin.procedure_prices');
        Route::put('/admin/procedure-prices/{id}', [ProcedurePriceController::class, 'update'])->name('admin.procedure_prices.update');
        
        // Add the store route for adding new procedure prices
        Route::post('/admin/procedure-prices', [ProcedurePriceController::class, 'store'])->name('admin.procedure_prices.store');
      
        Route::delete('/admin/procedure_prices/{id}', [ProcedurePriceController::class, 'destroy'])->name('admin.procedure_prices.destroy');

        Route::get('admin/declined-appointments', [AdminAppointment::class, 'declinedAppointments'])->name('admin.declined_appointments');


Route::delete('admin/appointments/delete-all-declined', [AdminAppointment::class, 'deleteAllDeclined'])
    ->name('appointments.deleteAllDeclined');

    Route::post('admin/appointment/{id}/{action}', [AdminAppointment::class, 'messageFromAdmin'])->name('appointment.messageFromAdmin');

    });
    
    Route::get('/get-procedure-details', [ProcedurePriceController::class, 'getProcedureDetails'])->name('getProcedureDetails');
    // Define a new route to fetch the procedure price based on the procedure name
Route::get('/get-procedure-price', [AppointmentController::class, 'getProcedurePrice'])->name('getProcedurePrice');


    
    // Grouping routes that require authentication
    // routes/web.php
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    Route::get('/unread-messages-count', [MessageController::class, 'unreadMessagesCount'])->middleware('auth');
    Route::post('/mark-messages-as-read', [MessageController::class, 'markMessagesAsRead'])->middleware('auth');
    Route::get('/admin/unread-messages-count', [MessageController::class, 'getUnreadMessagesCount']);
    Route::post('/admin/mark-messages-read', [MessageController::class, 'markMessagesAsReadAdmin']);
    Route::post('/appointment/{id}/{action}', [AdminAppointment::class, 'messageFromAdmin'])
    ->name('appointment.messageFromAdmin');

 


    

    Route::get('/search', function () {
        $query = request('query');
        if (!$query) {
            return response()->json([]);
        }

        // Search logic in the database
        $results = DB::table('inventory')
            ->where('name', 'like', "%$query%")
            ->orWhere('price', 'like', "%$query%")
            ->orWhere('expiration_date', 'like', "%$query%")
            ->get();

        return response()->json($results);
    });

    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::get('/messages/unread-count', [MessageController::class, 'unreadMessagesCount'])->name('messages.unread-count');

        Route::get('/theme-settings', function () {
        return view('settings.theme-settings');
    })->name('theme.settings');

    use App\Http\Controllers\ThemeController;
    Route::post('/set-theme', [ThemeController::class, 'setTheme'])->name('set-theme');


    //facebook
    use App\Http\Controllers\SocialiteController;
    Route::controller(SocialiteController::class)->group(function () {
        Route::get('auth/redirection/{provider}', 'authProviderRedirection')->name('auth.redirection');
        Route::get('auth/{provider}/callback','socialAuthentication')->name('auth.callback');
    });

    //google

    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('redirect.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    // Include auth routes
    require __DIR__.'/auth.php';
