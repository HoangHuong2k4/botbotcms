# File Tree: laravel-cms-copied

**Generated:** 11/13/2025, 9:34:30 AM
**Root Path:** `/Users/eugene/Sites/laravel-cms`

```
├── 📁 app
│   ├── 📁 Exceptions
│   │   └── 🐘 Handler.php
│   ├── 📁 Http
│   │   ├── 📁 Controllers
│   │   │   └── 🐘 Controller.php
│   │   └── 📁 Middleware
│   │       └── 🐘 VerifyCsrfToken.php
│   ├── 📁 Models
│   │   └── 🐘 User.php
│   └── 📁 Providers
│       ├── 🐘 AppServiceProvider.php
│       ├── 🐘 EventServiceProvider.php
│       └── 🐘 RouteServiceProvider.php
├── 📁 bootstrap
│   └── 🐘 app.php
├── 📁 config
│   ├── 🐘 app.php
│   ├── 🐘 auth.php
│   ├── 🐘 cache.php
│   ├── 🐘 database.php
│   ├── 🐘 filesystems.php
│   ├── 🐘 mail.php
│   ├── 🐘 queue.php
│   ├── 🐘 services.php
│   └── 🐘 session.php
├── 📁 database
│   ├── 📁 factories
│   │   └── 🐘 UserFactory.php
│   ├── 📁 migrations
│   │   ├── 🐘 0001_01_01_000001_create_cache_table.php
│   │   ├── 🐘 2014_10_12_000000_create_users_table.php
│   │   ├── 🐘 2014_10_12_100000_create_password_reset_tokens_table.php
│   │   ├── 🐘 2019_01_05_053554_create_jobs_table.php
│   │   ├── 🐘 2019_08_19_000000_create_failed_jobs_table.php
│   │   ├── 🐘 2019_12_14_000001_create_personal_access_tokens_table.php
│   │   └── 🐘 2024_09_30_024515_create_sessions_table.php
│   ├── 📁 seeders
│   │   ├── 📁 files
│   │   │   ├── 📁 general
│   │   │   │   ├── 📄 favicon.ico
│   │   │   │   └── 📄 laravel.ico
│   │   │   ├── 📁 members
│   │   │   ├── 📁 news
│   │   │   └── 📁 users
│   │   ├── 🐘 BlogSeeder.php
│   │   ├── 🐘 CommentSeeder.php
│   │   ├── 🐘 CustomFieldSeeder.php
│   │   ├── 🐘 DatabaseSeeder.php
│   │   ├── 🐘 GallerySeeder.php
│   │   ├── 🐘 MemberSeeder.php
│   │   ├── 🐘 MenuSeeder.php
│   │   ├── 🐘 PageSeeder.php
│   │   ├── 🐘 ThemeOptionSeeder.php
│   │   └── 🐘 WidgetSeeder.php
│   ├── ⚙️ .gitignore
│   └── 📄 database.sqlite
├── 📁 dev
│   ├── 📁 core
│   │   ├── 📁 acl
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 email.php
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2016_06_10_230148_create_acl_tables.php
│   │   │   │       ├── 🐘 2023_02_16_042611_drop_table_password_resets.php
│   │   │   │       ├── 🐘 2023_05_10_075124_drop_column_id_in_role_users_table.php
│   │   │   │       ├── 🐘 2024_04_04_110758_update_value_column_in_user_meta_table.php
│   │   │   │       └── 🐘 2025_07_06_030754_add_phone_to_users_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 images
│   │   │   │   │   └── 📁 backgrounds
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 profile.js
│   │   │   │       └── 📄 role.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 email-templates
│   │   │   │   │   └── 📄 password-reminder.tpl
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 profile.js
│   │   │   │   │   └── 📄 role.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 auth
│   │   │   │       │   ├── 📁 includes
│   │   │   │       │   │   └── 🐘 submit.blade.php
│   │   │   │       │   ├── 🐘 form.blade.php
│   │   │   │       │   └── 🐘 master.blade.php
│   │   │   │       ├── 📁 layouts
│   │   │   │       │   └── 🐘 guest.blade.php
│   │   │   │       ├── 📁 roles
│   │   │   │       │   ├── 📁 includes
│   │   │   │       │   │   └── 🐘 extra-actions.blade.php
│   │   │   │       │   ├── 🐘 permissions-actions.blade.php
│   │   │   │       │   └── 🐘 permissions.blade.php
│   │   │   │       └── 📁 users
│   │   │   │           ├── 📁 partials
│   │   │   │           │   └── 🐘 role.blade.php
│   │   │   │           └── 📁 profile
│   │   │   │               ├── 🐘 actions.blade.php
│   │   │   │               └── 🐘 base.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 UserCreateCommand.php
│   │   │   │   │   └── 🐘 UserPasswordCommand.php
│   │   │   │   ├── 📁 Concerns
│   │   │   │   │   └── 🐘 HasPreferences.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   ├── 🐘 HasPermissions.php
│   │   │   │   │   └── 🐘 HasPreferences.php
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Seeders
│   │   │   │   │       └── 🐘 UserSeeder.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 UserStatusEnum.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 RoleAssignmentEvent.php
│   │   │   │   │   └── 🐘 RoleUpdateEvent.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Auth
│   │   │   │   │   │   ├── 🐘 AuthForm.php
│   │   │   │   │   │   ├── 🐘 ForgotPasswordForm.php
│   │   │   │   │   │   └── 🐘 ResetPasswordForm.php
│   │   │   │   │   ├── 🐘 PasswordForm.php
│   │   │   │   │   ├── 🐘 PreferenceForm.php
│   │   │   │   │   ├── 🐘 ProfileForm.php
│   │   │   │   │   ├── 🐘 RoleForm.php
│   │   │   │   │   └── 🐘 UserForm.php
│   │   │   │   ├── 📁 Hooks
│   │   │   │   │   └── 🐘 UserWidgetHook.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Auth
│   │   │   │   │   │   │   ├── 🐘 ForgotPasswordController.php
│   │   │   │   │   │   │   └── 🐘 ResetPasswordController.php
│   │   │   │   │   │   ├── 🐘 RoleController.php
│   │   │   │   │   │   └── 🐘 UserController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   ├── 🐘 Authenticate.php
│   │   │   │   │   │   ├── 🐘 CheckUserUpdatePermission.php
│   │   │   │   │   │   └── 🐘 RedirectIfAuthenticated.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 AssignRoleRequest.php
│   │   │   │   │       ├── 🐘 AvatarRequest.php
│   │   │   │   │       ├── 🐘 CreateUserRequest.php
│   │   │   │   │       ├── 🐘 ForgotPasswordRequest.php
│   │   │   │   │       ├── 🐘 PreferencePatchRequest.php
│   │   │   │   │       ├── 🐘 PreferenceRequest.php
│   │   │   │   │       ├── 🐘 ResetPasswordRequest.php
│   │   │   │   │       ├── 🐘 RoleCreateRequest.php
│   │   │   │   │       ├── 🐘 UpdatePasswordRequest.php
│   │   │   │   │       └── 🐘 UpdateProfileRequest.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 RoleAssignmentListener.php
│   │   │   │   │   └── 🐘 RoleUpdateListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 Activation.php
│   │   │   │   │   ├── 🐘 Role.php
│   │   │   │   │   ├── 🐘 User.php
│   │   │   │   │   └── 🐘 UserMeta.php
│   │   │   │   ├── 📁 Notifications
│   │   │   │   │   └── 🐘 ResetPasswordNotification.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 AclServiceProvider.php
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 RoleCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 ActivationRepository.php
│   │   │   │   │   │   ├── 🐘 RoleRepository.php
│   │   │   │   │   │   └── 🐘 UserRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 ActivationInterface.php
│   │   │   │   │       ├── 🐘 RoleInterface.php
│   │   │   │   │       └── 🐘 UserInterface.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   ├── 🐘 ActivateUserService.php
│   │   │   │   │   ├── 🐘 ChangePasswordService.php
│   │   │   │   │   └── 🐘 CreateUserService.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   ├── 🐘 RoleTable.php
│   │   │   │   │   └── 🐘 UserTable.php
│   │   │   │   └── 📁 Traits
│   │   │   │       ├── 🐘 AuthenticatesUsers.php
│   │   │   │       ├── 🐘 PermissionTrait.php
│   │   │   │       ├── 🐘 RedirectsUsers.php
│   │   │   │       ├── 🐘 RegistersUsers.php
│   │   │   │       ├── 🐘 ResetsPasswords.php
│   │   │   │       ├── 🐘 SendsPasswordResetEmails.php
│   │   │   │       ├── 🐘 ThrottlesLogins.php
│   │   │   │       └── 🐘 VerifiesEmails.php
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 base
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 assets.php
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2013_04_09_032329_create_base_tables.php
│   │   │   │       ├── 🐘 2022_07_10_034813_move_lang_folder_to_root.php
│   │   │   │       ├── 🐘 2022_09_01_000001_create_admin_notifications_tables.php
│   │   │   │       └── 🐘 2023_04_23_005903_add_column_permissions_to_admin_notifications.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 action-filter.php
│   │   │   │   ├── 🐘 common.php
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   ├── 🐘 html.php
│   │   │   │   ├── 🐘 meta-box.php
│   │   │   │   └── 🐘 sort.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   ├── 📁 libraries
│   │   │   │   │   │   ├── 🎨 select2.css
│   │   │   │   │   │   └── 🎨 select2.rtl.css
│   │   │   │   │   ├── 🎨 core.css
│   │   │   │   │   ├── 🎨 core.rtl.css
│   │   │   │   │   ├── 🎨 crop-image.css
│   │   │   │   │   ├── 🎨 error-pages.css
│   │   │   │   │   └── 🎨 tree-category.css
│   │   │   │   ├── 📁 fonts
│   │   │   │   ├── 📁 images
│   │   │   │   │   ├── 📁 email-icons
│   │   │   │   │   ├── 📁 emails
│   │   │   │   │   ├── 📁 pdf-symbols
│   │   │   │   │   └── 📄 favicon.ico
│   │   │   │   ├── 📁 img
│   │   │   │   │   └── 📁 flags
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 app.js
│   │   │   │   │   ├── 📄 cache.js
│   │   │   │   │   ├── 📄 cleanup.js
│   │   │   │   │   ├── 📄 core-ui.js
│   │   │   │   │   ├── 📄 core.js
│   │   │   │   │   ├── 📄 crop-image.js
│   │   │   │   │   ├── 📄 editor.js
│   │   │   │   │   ├── 📄 global-search.js
│   │   │   │   │   ├── 📄 license-activation.js
│   │   │   │   │   ├── 📄 license-component.js
│   │   │   │   │   ├── 📄 notification.js
│   │   │   │   │   ├── 📄 phone-number-field.js
│   │   │   │   │   ├── 📄 repeater-field.js
│   │   │   │   │   ├── 📄 system-info.js
│   │   │   │   │   ├── 📄 system-update.js
│   │   │   │   │   ├── 📄 tabler.js
│   │   │   │   │   ├── 📄 tags.js
│   │   │   │   │   ├── 📄 tree-category.js
│   │   │   │   │   └── 📄 vue-app.js
│   │   │   │   └── 📁 libraries
│   │   │   │       ├── 📁 apexchart
│   │   │   │       │   └── 🎨 apexcharts.css
│   │   │   │       ├── 📁 bootstrap-colorpicker
│   │   │   │       │   ├── 📁 css
│   │   │   │       │   └── 📁 js
│   │   │   │       ├── 📁 bootstrap-datepicker
│   │   │   │       │   ├── 📁 css
│   │   │   │       │   └── 📁 js
│   │   │   │       ├── 📁 bootstrap-datetimepicker
│   │   │   │       ├── 📁 bootstrap-timepicker
│   │   │   │       │   ├── 📁 css
│   │   │   │       │   └── 📁 js
│   │   │   │       ├── 📁 bootstrap3-editable
│   │   │   │       │   ├── 📁 css
│   │   │   │       │   │   └── 🎨 bootstrap-editable.css
│   │   │   │       │   ├── 📁 img
│   │   │   │       │   └── 📁 js
│   │   │   │       ├── 📁 ckeditor
│   │   │   │       │   ├── 📄 ckeditor.js
│   │   │   │       │   └── 🎨 content-styles.css
│   │   │   │       ├── 📁 codemirror
│   │   │   │       │   ├── 📁 addon
│   │   │   │       │   │   ├── 📁 display
│   │   │   │       │   │   │   └── 📄 autorefresh.js
│   │   │   │       │   │   └── 📁 hint
│   │   │   │       │   │       ├── 📄 anyword-hint.js
│   │   │   │       │   │       ├── 📄 css-hint.js
│   │   │   │       │   │       ├── 📄 html-hint.js
│   │   │   │       │   │       ├── 📄 javascript-hint.js
│   │   │   │       │   │       ├── 🎨 show-hint.css
│   │   │   │       │   │       ├── 📄 show-hint.js
│   │   │   │       │   │       └── 📄 xml-hint.js
│   │   │   │       │   ├── 📁 lib
│   │   │   │       │   │   ├── 🎨 codemirror.css
│   │   │   │       │   │   └── 📄 codemirror.js
│   │   │   │       │   └── 📁 mode
│   │   │   │       │       ├── 📄 css.js
│   │   │   │       │       ├── 📄 htmlmixed.js
│   │   │   │       │       ├── 📄 javascript.js
│   │   │   │       │       └── 📄 xml.js
│   │   │   │       ├── 📁 coloris
│   │   │   │       ├── 📁 counterup
│   │   │   │       ├── 📁 cropper
│   │   │   │       ├── 📁 datatables
│   │   │   │       │   ├── 📁 extensions
│   │   │   │       │   │   ├── 📁 Buttons
│   │   │   │       │   │   │   ├── 📁 css
│   │   │   │       │   │   │   └── 📁 js
│   │   │   │       │   │   ├── 📁 Pagination
│   │   │   │       │   │   │   ├── 📁 css
│   │   │   │       │   │   │   └── 📁 js
│   │   │   │       │   │   └── 📁 Responsive
│   │   │   │       │   │       ├── 📁 css
│   │   │   │       │   │       └── 📁 js
│   │   │   │       │   └── 📁 media
│   │   │   │       │       ├── 📁 css
│   │   │   │       │       ├── 📁 images
│   │   │   │       │       └── 📁 js
│   │   │   │       ├── 📁 dropzone
│   │   │   │       │   ├── 🎨 dropzone.css
│   │   │   │       │   └── 📄 dropzone.js
│   │   │   │       ├── 📁 fancybox
│   │   │   │       ├── 📁 flatpickr
│   │   │   │       ├── 📁 font-awesome
│   │   │   │       │   ├── 📁 css
│   │   │   │       │   └── 📁 webfonts
│   │   │   │       ├── 📁 intl-tel-input
│   │   │   │       │   ├── 📁 css
│   │   │   │       │   ├── 📁 img
│   │   │   │       │   └── 📁 js
│   │   │   │       │       └── 📄 utils.js
│   │   │   │       ├── 📁 jquery-cookie
│   │   │   │       │   └── 📄 jquery.cookie.js
│   │   │   │       ├── 📁 jquery-inputmask
│   │   │   │       │   └── 📁 inputmask
│   │   │   │       │       ├── 📁 bindings
│   │   │   │       │       ├── 📁 dependencyLibs
│   │   │   │       │       ├── 📁 global
│   │   │   │       │       └── 📁 phone-codes
│   │   │   │       ├── 📁 jquery-nestable
│   │   │   │       ├── 📁 jquery-tree
│   │   │   │       ├── 📁 jquery-treeview
│   │   │   │       │   └── 📁 images
│   │   │   │       ├── 📁 jquery-ui
│   │   │   │       │   └── 📁 images
│   │   │   │       ├── 📁 jquery-waypoints
│   │   │   │       ├── 📁 jquery.are-you-sure
│   │   │   │       │   └── 📄 jquery.are-you-sure.js
│   │   │   │       ├── 📁 mcustom-scrollbar
│   │   │   │       │   ├── 🎨 jquery.mCustomScrollbar.css
│   │   │   │       │   └── 📄 jquery.mCustomScrollbar.js
│   │   │   │       ├── 📁 modernizr
│   │   │   │       ├── 📁 morris
│   │   │   │       │   └── 🎨 morris.css
│   │   │   │       ├── 📁 pace
│   │   │   │       │   └── 🎨 pace-theme-minimal.css
│   │   │   │       ├── 📁 select2
│   │   │   │       │   ├── 📁 css
│   │   │   │       │   └── 📁 js
│   │   │   │       ├── 📁 sortable
│   │   │   │       ├── 📁 spectrum
│   │   │   │       │   ├── 🎨 spectrum.css
│   │   │   │       │   └── 📄 spectrum.js
│   │   │   │       ├── 📁 stickytableheaders
│   │   │   │       │   └── 📄 jquery.stickytableheaders.js
│   │   │   │       ├── 📁 tagify
│   │   │   │       │   ├── 🎨 tagify.css
│   │   │   │       │   └── 📄 tagify.js
│   │   │   │       ├── 📁 tinymce
│   │   │   │       │   ├── 📁 icons
│   │   │   │       │   │   └── 📁 default
│   │   │   │       │   ├── 📁 plugins
│   │   │   │       │   │   ├── 📁 advlist
│   │   │   │       │   │   ├── 📁 anchor
│   │   │   │       │   │   ├── 📁 autolink
│   │   │   │       │   │   ├── 📁 autoresize
│   │   │   │       │   │   ├── 📁 autosave
│   │   │   │       │   │   ├── 📁 bbcode
│   │   │   │       │   │   ├── 📁 charmap
│   │   │   │       │   │   ├── 📁 code
│   │   │   │       │   │   ├── 📁 codesample
│   │   │   │       │   │   ├── 📁 colorpicker
│   │   │   │       │   │   ├── 📁 directionality
│   │   │   │       │   │   ├── 📁 emoticons
│   │   │   │       │   │   │   └── 📁 js
│   │   │   │       │   │   │       ├── 📄 emojiimages.js
│   │   │   │       │   │   │       └── 📄 emojis.js
│   │   │   │       │   │   ├── 📁 fullpage
│   │   │   │       │   │   ├── 📁 fullscreen
│   │   │   │       │   │   ├── 📁 help
│   │   │   │       │   │   ├── 📁 hr
│   │   │   │       │   │   ├── 📁 image
│   │   │   │       │   │   ├── 📁 imagetools
│   │   │   │       │   │   ├── 📁 importcss
│   │   │   │       │   │   ├── 📁 insertdatetime
│   │   │   │       │   │   ├── 📁 legacyoutput
│   │   │   │       │   │   ├── 📁 link
│   │   │   │       │   │   ├── 📁 lists
│   │   │   │       │   │   ├── 📁 media
│   │   │   │       │   │   ├── 📁 nonbreaking
│   │   │   │       │   │   ├── 📁 noneditable
│   │   │   │       │   │   ├── 📁 pagebreak
│   │   │   │       │   │   ├── 📁 paste
│   │   │   │       │   │   ├── 📁 preview
│   │   │   │       │   │   ├── 📁 print
│   │   │   │       │   │   ├── 📁 quickbars
│   │   │   │       │   │   ├── 📁 save
│   │   │   │       │   │   ├── 📁 searchreplace
│   │   │   │       │   │   ├── 📁 spellchecker
│   │   │   │       │   │   ├── 📁 tabfocus
│   │   │   │       │   │   ├── 📁 table
│   │   │   │       │   │   ├── 📁 template
│   │   │   │       │   │   ├── 📁 textpattern
│   │   │   │       │   │   ├── 📁 toc
│   │   │   │       │   │   ├── 📁 visualblocks
│   │   │   │       │   │   ├── 📁 visualchars
│   │   │   │       │   │   └── 📁 wordcount
│   │   │   │       │   ├── 📁 skins
│   │   │   │       │   │   ├── 📁 content
│   │   │   │       │   │   │   ├── 📁 dark
│   │   │   │       │   │   │   ├── 📁 default
│   │   │   │       │   │   │   ├── 📁 document
│   │   │   │       │   │   │   └── 📁 writer
│   │   │   │       │   │   └── 📁 ui
│   │   │   │       │   │       ├── 📁 oxide
│   │   │   │       │   │       │   └── 📁 fonts
│   │   │   │       │   │       └── 📁 oxide-dark
│   │   │   │       │   │           └── 📁 fonts
│   │   │   │       │   ├── 📁 themes
│   │   │   │       │   │   ├── 📁 mobile
│   │   │   │       │   │   └── 📁 silver
│   │   │   │       │   ├── 📄 license.txt
│   │   │   │       │   └── 📄 tinymce.d.ts
│   │   │   │       ├── 📁 toastr
│   │   │   │       ├── 📄 fslightbox.js
│   │   │   │       └── 📄 raphael-min.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 data
│   │   │   │   │   └── ⚙️ google-fonts.json
│   │   │   │   ├── 📁 email-templates
│   │   │   │   │   ├── 🎨 default.css
│   │   │   │   │   ├── 📄 footer.tpl
│   │   │   │   │   └── 📄 header.tpl
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📁 base
│   │   │   │   │   │   ├── 📄 progress.js
│   │   │   │   │   │   └── 📄 toast.js
│   │   │   │   │   ├── 📁 components
│   │   │   │   │   │   └── 📄 SystemUpdateComponent.vue
│   │   │   │   │   ├── 📁 form
│   │   │   │   │   │   └── 📄 phone-number-field.js
│   │   │   │   │   ├── 📁 utilities
│   │   │   │   │   │   ├── 📄 http-client.js
│   │   │   │   │   │   ├── 📄 index.d.ts
│   │   │   │   │   │   ├── 📄 index.js
│   │   │   │   │   │   └── 📄 pending-request.js
│   │   │   │   │   ├── 📄 app.js
│   │   │   │   │   ├── 📄 cache.js
│   │   │   │   │   ├── 📄 ckeditor-upload-adapter.js
│   │   │   │   │   ├── 📄 cleanup.js
│   │   │   │   │   ├── 📄 core-ui.js
│   │   │   │   │   ├── 📄 core.js
│   │   │   │   │   ├── 📄 crop-image.js
│   │   │   │   │   ├── 📄 editor.js
│   │   │   │   │   ├── 📄 global-search.js
│   │   │   │   │   ├── 📄 license-activation.js
│   │   │   │   │   ├── 📄 notification.js
│   │   │   │   │   ├── 📄 repeater-field.js
│   │   │   │   │   ├── 📄 system-info.js
│   │   │   │   │   ├── 📄 system-update.js
│   │   │   │   │   ├── 📄 tags.js
│   │   │   │   │   ├── 📄 tree-category.js
│   │   │   │   │   └── 📄 vue-app.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   ├── 📁 components
│   │   │   │   │   │   ├── 🎨 crop-image.scss
│   │   │   │   │   │   ├── 🎨 error-pages.scss
│   │   │   │   │   │   └── 🎨 tree-category.scss
│   │   │   │   │   ├── 📁 libraries
│   │   │   │   │   │   ├── 📁 select2
│   │   │   │   │   │   │   ├── 🎨 _disabled.scss
│   │   │   │   │   │   │   ├── 🎨 _dropdown.scss
│   │   │   │   │   │   │   ├── 🎨 _include-all.scss
│   │   │   │   │   │   │   ├── 🎨 _input-group.scss
│   │   │   │   │   │   │   ├── 🎨 _layout.scss
│   │   │   │   │   │   │   ├── 🎨 _multiple.scss
│   │   │   │   │   │   │   ├── 🎨 _single.scss
│   │   │   │   │   │   │   ├── 🎨 _sizing.scss
│   │   │   │   │   │   │   ├── 🎨 _validation.scss
│   │   │   │   │   │   │   ├── 🎨 _variables.scss
│   │   │   │   │   │   │   └── 🎨 select2.scss
│   │   │   │   │   │   └── 🎨 _select2.scss
│   │   │   │   │   ├── 📁 partials
│   │   │   │   │   │   ├── 🎨 _acl.scss
│   │   │   │   │   │   ├── 🎨 _core.scss
│   │   │   │   │   │   ├── 🎨 _custom.scss
│   │   │   │   │   │   ├── 🎨 _dashboard.scss
│   │   │   │   │   │   ├── 🎨 _datetimepicker.scss
│   │   │   │   │   │   ├── 🎨 _dropzone.scss
│   │   │   │   │   │   ├── 🎨 _flags.scss
│   │   │   │   │   │   ├── 🎨 _form.scss
│   │   │   │   │   │   ├── 🎨 _global-search.scss
│   │   │   │   │   │   ├── 🎨 _image-picker.scss
│   │   │   │   │   │   ├── 🎨 _loading.scss
│   │   │   │   │   │   ├── 🎨 _modal.scss
│   │   │   │   │   │   ├── 🎨 _navbar.scss
│   │   │   │   │   │   ├── 🎨 _notification.scss
│   │   │   │   │   │   ├── 🎨 _old-style.scss
│   │   │   │   │   │   ├── 🎨 _rtl.scss
│   │   │   │   │   │   ├── 🎨 _setting.scss
│   │   │   │   │   │   ├── 🎨 _table-mobile-responsive.scss
│   │   │   │   │   │   ├── 🎨 _ui-selector.scss
│   │   │   │   │   │   ├── 🎨 _variable.scss
│   │   │   │   │   │   ├── 🎨 _widget.scss
│   │   │   │   │   │   └── 🎨 utilities.scss
│   │   │   │   │   └── 🎨 core.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 components
│   │   │   │       │   ├── 📁 card
│   │   │   │       │   │   ├── 📁 body
│   │   │   │       │   │   │   └── 🐘 index.blade.php
│   │   │   │       │   │   ├── 📁 footer
│   │   │   │       │   │   │   └── 🐘 index.blade.php
│   │   │   │       │   │   ├── 📁 header
│   │   │   │       │   │   │   ├── 🐘 button.blade.php
│   │   │   │       │   │   │   └── 🐘 index.blade.php
│   │   │   │       │   │   ├── 🐘 actions.blade.php
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   ├── 🐘 subtitle.blade.php
│   │   │   │       │   │   └── 🐘 title.blade.php
│   │   │   │       │   ├── 📁 datagrid
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   └── 🐘 item.blade.php
│   │   │   │       │   ├── 📁 dropdown
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   └── 🐘 item.blade.php
│   │   │   │       │   ├── 📁 form
│   │   │   │       │   │   ├── 📁 on-off
│   │   │   │       │   │   │   ├── 🐘 checkbox.blade.php
│   │   │   │       │   │   │   └── 🐘 index.blade.php
│   │   │   │       │   │   ├── 🐘 checkbox.blade.php
│   │   │   │       │   │   ├── 🐘 code-editor.blade.php
│   │   │   │       │   │   ├── 🐘 color-picker.blade.php
│   │   │   │       │   │   ├── 🐘 color-selector.blade.php
│   │   │   │       │   │   ├── 🐘 error.blade.php
│   │   │   │       │   │   ├── 🐘 field.blade.php
│   │   │   │       │   │   ├── 🐘 fieldset.blade.php
│   │   │   │       │   │   ├── 🐘 helper-text.blade.php
│   │   │   │       │   │   ├── 🐘 image-check.blade.php
│   │   │   │       │   │   ├── 🐘 image.blade.php
│   │   │   │       │   │   ├── 🐘 images.blade.php
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   ├── 🐘 label.blade.php
│   │   │   │       │   │   ├── 🐘 radio-list.blade.php
│   │   │   │       │   │   ├── 🐘 radio.blade.php
│   │   │   │       │   │   ├── 🐘 select.blade.php
│   │   │   │       │   │   ├── 🐘 text-input.blade.php
│   │   │   │       │   │   ├── 🐘 textarea.blade.php
│   │   │   │       │   │   └── 🐘 toggle.blade.php
│   │   │   │       │   ├── 📁 layouts
│   │   │   │       │   │   ├── 🐘 base.blade.php
│   │   │   │       │   │   └── 🐘 header.blade.php
│   │   │   │       │   ├── 📁 license
│   │   │   │       │   │   └── 🐘 form.blade.php
│   │   │   │       │   ├── 📁 list-group
│   │   │   │       │   │   ├── 🐘 header.blade.php
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   └── 🐘 item.blade.php
│   │   │   │       │   ├── 📁 modal
│   │   │   │       │   │   ├── 🐘 action-button.blade.php
│   │   │   │       │   │   ├── 🐘 action.blade.php
│   │   │   │       │   │   ├── 🐘 alert.blade.php
│   │   │   │       │   │   ├── 🐘 close-button.blade.php
│   │   │   │       │   │   └── 🐘 push-once.blade.php
│   │   │   │       │   ├── 📁 navbar
│   │   │   │       │   │   └── 🐘 badge-count.blade.php
│   │   │   │       │   ├── 📁 offcanvas
│   │   │   │       │   │   ├── 🐘 body.blade.php
│   │   │   │       │   │   ├── 🐘 close-button.blade.php
│   │   │   │       │   │   ├── 🐘 header.blade.php
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   └── 🐘 title.blade.php
│   │   │   │       │   ├── 📁 stat-widget
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   └── 🐘 item.blade.php
│   │   │   │       │   ├── 📁 step
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   └── 🐘 item.blade.php
│   │   │   │       │   ├── 📁 tab
│   │   │   │       │   │   ├── 🐘 content.blade.php
│   │   │   │       │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   ├── 🐘 item.blade.php
│   │   │   │       │   │   └── 🐘 pane.blade.php
│   │   │   │       │   ├── 📁 table
│   │   │   │       │   │   ├── 📁 body
│   │   │   │       │   │   │   ├── 🐘 cell.blade.php
│   │   │   │       │   │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   │   └── 🐘 row.blade.php
│   │   │   │       │   │   ├── 📁 footer
│   │   │   │       │   │   │   ├── 🐘 cell.blade.php
│   │   │   │       │   │   │   ├── 🐘 index.blade.php
│   │   │   │       │   │   │   └── 🐘 row.blade.php
│   │   │   │       │   │   ├── 📁 header
│   │   │   │       │   │   │   ├── 🐘 cell.blade.php
│   │   │   │       │   │   │   └── 🐘 index.blade.php
│   │   │   │       │   │   └── 🐘 index.blade.php
│   │   │   │       │   ├── 🐘 alert.blade.php
│   │   │   │       │   ├── 🐘 badge.blade.php
│   │   │   │       │   ├── 🐘 button.blade.php
│   │   │   │       │   ├── 🐘 copy.blade.php
│   │   │   │       │   ├── 🐘 crop-image.blade.php
│   │   │   │       │   ├── 🐘 custom-template.blade.php
│   │   │   │       │   ├── 🐘 debug-badge.blade.php
│   │   │   │       │   ├── 🐘 empty-state.blade.php
│   │   │   │       │   ├── 🐘 form-group.blade.php
│   │   │   │       │   ├── 🐘 hr.blade.php
│   │   │   │       │   ├── 🐘 icon.blade.php
│   │   │   │       │   ├── 🐘 image.blade.php
│   │   │   │       │   ├── 🐘 loading.blade.php
│   │   │   │       │   ├── 🐘 modal.blade.php
│   │   │   │       │   ├── 🐘 panel-section.blade.php
│   │   │   │       │   ├── 🐘 simple-pagination.blade.php
│   │   │   │       │   └── 🐘 twig-editor.blade.php
│   │   │   │       ├── 📁 elements
│   │   │   │       │   ├── 🐘 common.blade.php
│   │   │   │       │   ├── 🐘 loading.blade.php
│   │   │   │       │   ├── 🐘 meta-box-wrap.blade.php
│   │   │   │       │   └── 🐘 meta-box.blade.php
│   │   │   │       ├── 📁 emails
│   │   │   │       │   └── 🐘 error-reporting.blade.php
│   │   │   │       ├── 📁 errors
│   │   │   │       │   ├── 🐘 404.blade.php
│   │   │   │       │   ├── 🐘 500.blade.php
│   │   │   │       │   ├── 🐘 503.blade.php
│   │   │   │       │   └── 🐘 master.blade.php
│   │   │   │       ├── 📁 forms
│   │   │   │       │   ├── 📁 columns
│   │   │   │       │   │   ├── 🐘 column-span.blade.php
│   │   │   │       │   │   └── 🐘 form-open-wrapper.blade.php
│   │   │   │       │   ├── 📁 fields
│   │   │   │       │   │   ├── 🐘 alert.blade.php
│   │   │   │       │   │   ├── 🐘 autocomplete.blade.php
│   │   │   │       │   │   ├── 🐘 checkbox.blade.php
│   │   │   │       │   │   ├── 🐘 ckeditor.blade.php
│   │   │   │       │   │   ├── 🐘 code-editor.blade.php
│   │   │   │       │   │   ├── 🐘 color-selector.blade.php
│   │   │   │       │   │   ├── 🐘 color.blade.php
│   │   │   │       │   │   ├── 🐘 core-icon.blade.php
│   │   │   │       │   │   ├── 🐘 custom-radio.blade.php
│   │   │   │       │   │   ├── 🐘 custom-select.blade.php
│   │   │   │       │   │   ├── 🐘 date-picker.blade.php
│   │   │   │       │   │   ├── 🐘 date.blade.php
│   │   │   │       │   │   ├── 🐘 datetime.blade.php
│   │   │   │       │   │   ├── 🐘 editor.blade.php
│   │   │   │       │   │   ├── 🐘 email.blade.php
│   │   │   │       │   │   ├── 🐘 fieldset.blade.php
│   │   │   │       │   │   ├── 🐘 file.blade.php
│   │   │   │       │   │   ├── 🐘 google-fonts.blade.php
│   │   │   │       │   │   ├── 🐘 hidden.blade.php
│   │   │   │       │   │   ├── 🐘 html.blade.php
│   │   │   │       │   │   ├── 🐘 label.blade.php
│   │   │   │       │   │   ├── 🐘 media-file.blade.php
│   │   │   │       │   │   ├── 🐘 media-image.blade.php
│   │   │   │       │   │   ├── 🐘 media-images.blade.php
│   │   │   │       │   │   ├── 🐘 multi-check-list.blade.php
│   │   │   │       │   │   ├── 🐘 number.blade.php
│   │   │   │       │   │   ├── 🐘 on-off-checkbox.blade.php
│   │   │   │       │   │   ├── 🐘 on-off.blade.php
│   │   │   │       │   │   ├── 🐘 password-toggle-script.blade.php
│   │   │   │       │   │   ├── 🐘 password.blade.php
│   │   │   │       │   │   ├── 🐘 phone-number.blade.php
│   │   │   │       │   │   ├── 🐘 repeater.blade.php
│   │   │   │       │   │   ├── 🐘 tags.blade.php
│   │   │   │       │   │   ├── 🐘 text.blade.php
│   │   │   │       │   │   ├── 🐘 textarea.blade.php
│   │   │   │       │   │   ├── 🐘 time-picker.blade.php
│   │   │   │       │   │   ├── 🐘 time.blade.php
│   │   │   │       │   │   ├── 🐘 tinymce.blade.php
│   │   │   │       │   │   ├── 🐘 tree-categories.blade.php
│   │   │   │       │   │   └── 🐘 ui-selector.blade.php
│   │   │   │       │   ├── 📁 partials
│   │   │   │       │   │   ├── 🐘 autocomplete.blade.php
│   │   │   │       │   │   ├── 🐘 ckeditor.blade.php
│   │   │   │       │   │   ├── 🐘 code-editor.blade.php
│   │   │   │       │   │   ├── 🐘 color.blade.php
│   │   │   │       │   │   ├── 🐘 core-icon.blade.php
│   │   │   │       │   │   ├── 🐘 custom-checkbox.blade.php
│   │   │   │       │   │   ├── 🐘 custom-radio.blade.php
│   │   │   │       │   │   ├── 🐘 custom-select.blade.php
│   │   │   │       │   │   ├── 🐘 date-picker.blade.php
│   │   │   │       │   │   ├── 🐘 editor.blade.php
│   │   │   │       │   │   ├── 🐘 error.blade.php
│   │   │   │       │   │   ├── 🐘 errors.blade.php
│   │   │   │       │   │   ├── 🐘 file.blade.php
│   │   │   │       │   │   ├── 🐘 form-actions.blade.php
│   │   │   │       │   │   ├── 🐘 form-buttons.blade.php
│   │   │   │       │   │   ├── 🐘 google-fonts.blade.php
│   │   │   │       │   │   ├── 🐘 help-block.blade.php
│   │   │   │       │   │   ├── 🐘 helper.blade.php
│   │   │   │       │   │   ├── 🐘 image-box.blade.php
│   │   │   │       │   │   ├── 🐘 image.blade.php
│   │   │   │       │   │   ├── 🐘 images.blade.php
│   │   │   │       │   │   ├── 🐘 label.blade.php
│   │   │   │       │   │   ├── 🐘 meta-box.blade.php
│   │   │   │       │   │   ├── 🐘 modal.blade.php
│   │   │   │       │   │   ├── 🐘 multi-checklist.blade.php
│   │   │   │       │   │   ├── 🐘 nested-select-dropdown.blade.php
│   │   │   │       │   │   ├── 🐘 nested-select-option.blade.php
│   │   │   │       │   │   ├── 🐘 on-off-checkbox.blade.php
│   │   │   │       │   │   ├── 🐘 on-off.blade.php
│   │   │   │       │   │   ├── 🐘 phone-number.blade.php
│   │   │   │       │   │   ├── 🐘 repeater-group.blade.php
│   │   │   │       │   │   ├── 🐘 repeater-item.blade.php
│   │   │   │       │   │   ├── 🐘 repeater-template.blade.php
│   │   │   │       │   │   ├── 🐘 repeater.blade.php
│   │   │   │       │   │   ├── 🐘 time-picker.blade.php
│   │   │   │       │   │   ├── 🐘 tinymce.blade.php
│   │   │   │       │   │   ├── 🐘 toolbox.blade.php
│   │   │   │       │   │   ├── 🐘 tree-categories-checkbox-options.blade.php
│   │   │   │       │   │   ├── 🐘 tree-categories-select-options.blade.php
│   │   │   │       │   │   ├── 🐘 tree-categories.blade.php
│   │   │   │       │   │   ├── 🐘 tree-category.blade.php
│   │   │   │       │   │   └── 🐘 ui-selector.blade.php
│   │   │   │       │   ├── 📁 tabs
│   │   │   │       │   │   ├── 🐘 tab-content.blade.php
│   │   │   │       │   │   └── 🐘 tab-item.blade.php
│   │   │   │       │   ├── 🐘 form-content-only.blade.php
│   │   │   │       │   ├── 🐘 form-limit-size.blade.php
│   │   │   │       │   ├── 🐘 form-no-wrap.blade.php
│   │   │   │       │   ├── 🐘 form-tabs.blade.php
│   │   │   │       │   ├── 🐘 form-tree-category.blade.php
│   │   │   │       │   └── 🐘 form.blade.php
│   │   │   │       ├── 📁 global-search
│   │   │   │       │   ├── 🐘 form.blade.php
│   │   │   │       │   ├── 🐘 index.blade.php
│   │   │   │       │   └── 🐘 navbar-input.blade.php
│   │   │   │       ├── 📁 layouts
│   │   │   │       │   ├── 📁 horizontal
│   │   │   │       │   │   └── 📁 partials
│   │   │   │       │   │       ├── 🐘 after-content.blade.php
│   │   │   │       │   │       ├── 🐘 before-content.blade.php
│   │   │   │       │   │       ├── 🐘 header-expand.blade.php
│   │   │   │       │   │       ├── 🐘 navbar-nav.blade.php
│   │   │   │       │   │       └── 🐘 navbar.blade.php
│   │   │   │       │   ├── 📁 partials
│   │   │   │       │   │   ├── 🐘 breadcrumbs.blade.php
│   │   │   │       │   │   ├── 🐘 footer.blade.php
│   │   │   │       │   │   ├── 🐘 navbar-nav-item-link.blade.php
│   │   │   │       │   │   ├── 🐘 navbar-nav-item.blade.php
│   │   │   │       │   │   ├── 🐘 navbar-nav.blade.php
│   │   │   │       │   │   ├── 🐘 page-header.blade.php
│   │   │   │       │   │   ├── 🐘 theme-toggle.blade.php
│   │   │   │       │   │   └── 🐘 user-menu.blade.php
│   │   │   │       │   ├── 📁 vertical
│   │   │   │       │   │   └── 📁 partials
│   │   │   │       │   │       ├── 🐘 after-content.blade.php
│   │   │   │       │   │       ├── 🐘 aside.blade.php
│   │   │   │       │   │       ├── 🐘 before-content.blade.php
│   │   │   │       │   │       ├── 🐘 header.blade.php
│   │   │   │       │   │       ├── 🐘 navbar.blade.php
│   │   │   │       │   │       └── 🐘 sidebar.blade.php
│   │   │   │       │   ├── 🐘 empty.blade.php
│   │   │   │       │   └── 🐘 master.blade.php
│   │   │   │       ├── 📁 notification
│   │   │   │       │   ├── 📁 partials
│   │   │   │       │   │   ├── 🐘 content.blade.php
│   │   │   │       │   │   └── 🐘 notification-item.blade.php
│   │   │   │       │   ├── 🐘 nav-item.blade.php
│   │   │   │       │   └── 🐘 notification.blade.php
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 📁 navbar
│   │   │   │       │   │   └── 🐘 badge-count.blade.php
│   │   │   │       │   └── 🐘 copyright.blade.php
│   │   │   │       ├── 📁 pdf
│   │   │   │       │   ├── 🐘 style-bangladesh.blade.php
│   │   │   │       │   └── 🐘 style-chinese.blade.php
│   │   │   │       ├── 📁 sections
│   │   │   │       │   ├── 🐘 empty.blade.php
│   │   │   │       │   ├── 🐘 item.blade.php
│   │   │   │       │   └── 🐘 section.blade.php
│   │   │   │       ├── 📁 system
│   │   │   │       │   ├── 📁 partials
│   │   │   │       │   │   ├── 🐘 cache-too-large-alert.blade.php
│   │   │   │       │   │   ├── 🐘 info-dependencies-line.blade.php
│   │   │   │       │   │   ├── 🐘 info-package-line.blade.php
│   │   │   │       │   │   ├── 🐘 license-activation-modal.blade.php
│   │   │   │       │   │   └── 🐘 status-icon.blade.php
│   │   │   │       │   ├── 🐘 cache.blade.php
│   │   │   │       │   ├── 🐘 cleanup.blade.php
│   │   │   │       │   ├── 🐘 index.blade.php
│   │   │   │       │   ├── 🐘 info.blade.php
│   │   │   │       │   ├── 🐘 license-invalid.blade.php
│   │   │   │       │   ├── 🐘 unlicensed.blade.php
│   │   │   │       │   └── 🐘 updater.blade.php
│   │   │   │       ├── 📁 themes
│   │   │   │       │   ├── 🐘 404.blade.php
│   │   │   │       │   └── 🐘 500.blade.php
│   │   │   │       ├── 📁 widgets
│   │   │   │       │   ├── 📁 partials
│   │   │   │       │   │   └── 🐘 chart-script.blade.php
│   │   │   │       │   ├── 🐘 card.blade.php
│   │   │   │       │   ├── 🐘 chart.blade.php
│   │   │   │       │   ├── 🐘 html.blade.php
│   │   │   │       │   ├── 🐘 render.blade.php
│   │   │   │       │   └── 🐘 table.blade.php
│   │   │   │       └── 🐘 breadcrumb.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Casts
│   │   │   │   │   └── 🐘 SafeContent.php
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 📁 Traits
│   │   │   │   │   │   └── 🐘 ValidateCommandInput.php
│   │   │   │   │   ├── 🐘 ActivateLicenseCommand.php
│   │   │   │   │   ├── 🐘 CacheWarmCommand.php
│   │   │   │   │   ├── 🐘 CleanupSystemCommand.php
│   │   │   │   │   ├── 🐘 ClearExpiredCacheCommand.php
│   │   │   │   │   ├── 🐘 ClearLogCommand.php
│   │   │   │   │   ├── 🐘 CompressImagesCommand.php
│   │   │   │   │   ├── 🐘 ExportDatabaseCommand.php
│   │   │   │   │   ├── 🐘 FetchGoogleFontsCommand.php
│   │   │   │   │   ├── 🐘 GoogleFontsUpdateCommand.php
│   │   │   │   │   ├── 🐘 ImportDatabaseCommand.php
│   │   │   │   │   ├── 🐘 InstallCommand.php
│   │   │   │   │   ├── 🐘 PublishAssetsCommand.php
│   │   │   │   │   └── 🐘 UpdateCommand.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   ├── 📁 Builders
│   │   │   │   │   │   └── 🐘 Extensible.php
│   │   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   │   └── 🐘 IgnoringReport.php
│   │   │   │   │   ├── 📁 PanelSections
│   │   │   │   │   │   ├── 🐘 Manager.php
│   │   │   │   │   │   ├── 🐘 PanelSection.php
│   │   │   │   │   │   └── 🐘 PanelSectionItem.php
│   │   │   │   │   ├── 🐘 BaseModel.php
│   │   │   │   │   ├── 🐘 GlobalSearchableManager.php
│   │   │   │   │   ├── 🐘 GlobalSearchableProvider.php
│   │   │   │   │   ├── 🐘 GlobalSearchableResult.php
│   │   │   │   │   └── 🐘 HasTreeCategory.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   ├── 🐘 BaseStatusEnum.php
│   │   │   │   │   └── 🐘 SystemUpdaterStepEnum.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 AdminNotificationEvent.php
│   │   │   │   │   ├── 🐘 BeforeCreateContentEvent.php
│   │   │   │   │   ├── 🐘 BeforeEditContentEvent.php
│   │   │   │   │   ├── 🐘 BeforeUpdateContentEvent.php
│   │   │   │   │   ├── 🐘 CacheCleared.php
│   │   │   │   │   ├── 🐘 CreatedContentEvent.php
│   │   │   │   │   ├── 🐘 DashboardMenuRetrieved.php
│   │   │   │   │   ├── 🐘 DashboardMenuRetrieving.php
│   │   │   │   │   ├── 🐘 DeletedContentEvent.php
│   │   │   │   │   ├── 🐘 EditorAssetRegistered.php
│   │   │   │   │   ├── 🐘 EditorAssetRegistering.php
│   │   │   │   │   ├── 🐘 EditorRendered.php
│   │   │   │   │   ├── 🐘 EditorRendering.php
│   │   │   │   │   ├── 🐘 Event.php
│   │   │   │   │   ├── 🐘 FinishedSeederEvent.php
│   │   │   │   │   ├── 🐘 FormRendering.php
│   │   │   │   │   ├── 🐘 LicenseActivated.php
│   │   │   │   │   ├── 🐘 LicenseActivating.php
│   │   │   │   │   ├── 🐘 LicenseDeactivated.php
│   │   │   │   │   ├── 🐘 LicenseDeactivating.php
│   │   │   │   │   ├── 🐘 LicenseInvalid.php
│   │   │   │   │   ├── 🐘 LicenseRevoked.php
│   │   │   │   │   ├── 🐘 LicenseRevoking.php
│   │   │   │   │   ├── 🐘 LicenseUnverified.php
│   │   │   │   │   ├── 🐘 LicenseVerified.php
│   │   │   │   │   ├── 🐘 LicenseVerifying.php
│   │   │   │   │   ├── 🐘 PanelSectionItemRendered.php
│   │   │   │   │   ├── 🐘 PanelSectionItemRendering.php
│   │   │   │   │   ├── 🐘 PanelSectionItemsRendered.php
│   │   │   │   │   ├── 🐘 PanelSectionItemsRendering.php
│   │   │   │   │   ├── 🐘 PanelSectionRendered.php
│   │   │   │   │   ├── 🐘 PanelSectionRendering.php
│   │   │   │   │   ├── 🐘 PanelSectionsRendered.php
│   │   │   │   │   ├── 🐘 PanelSectionsRendering.php
│   │   │   │   │   ├── 🐘 RenderingAdminWidgetEvent.php
│   │   │   │   │   ├── 🐘 SeederPrepared.php
│   │   │   │   │   ├── 🐘 SendMailEvent.php
│   │   │   │   │   ├── 🐘 SystemUpdateAvailable.php
│   │   │   │   │   ├── 🐘 SystemUpdateCachesCleared.php
│   │   │   │   │   ├── 🐘 SystemUpdateCachesClearing.php
│   │   │   │   │   ├── 🐘 SystemUpdateChecked.php
│   │   │   │   │   ├── 🐘 SystemUpdateChecking.php
│   │   │   │   │   ├── 🐘 SystemUpdateDBMigrated.php
│   │   │   │   │   ├── 🐘 SystemUpdateDBMigrating.php
│   │   │   │   │   ├── 🐘 SystemUpdateDownloaded.php
│   │   │   │   │   ├── 🐘 SystemUpdateDownloading.php
│   │   │   │   │   ├── 🐘 SystemUpdateExtractedFiles.php
│   │   │   │   │   ├── 🐘 SystemUpdateExtractingFiles.php
│   │   │   │   │   ├── 🐘 SystemUpdatePublished.php
│   │   │   │   │   ├── 🐘 SystemUpdatePublishing.php
│   │   │   │   │   ├── 🐘 SystemUpdateUnavailable.php
│   │   │   │   │   ├── 🐘 UpdatedContentEvent.php
│   │   │   │   │   ├── 🐘 UpdatedEvent.php
│   │   │   │   │   └── 🐘 UpdatingEvent.php
│   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   ├── 🐘 CouldNotConnectToLicenseServerException.php
│   │   │   │   │   ├── 🐘 DisabledInDemoModeException.php
│   │   │   │   │   ├── 🐘 FileNotWritableException.php
│   │   │   │   │   ├── 🐘 Handler.php
│   │   │   │   │   ├── 🐘 LicenseInvalidException.php
│   │   │   │   │   ├── 🐘 LicenseIsAlreadyActivatedException.php
│   │   │   │   │   ├── 🐘 MigrateDataException.php
│   │   │   │   │   ├── 🐘 MissingCURLExtensionException.php
│   │   │   │   │   ├── 🐘 MissingZipExtensionException.php
│   │   │   │   │   └── 🐘 RequiresLicenseActivatedException.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   ├── 🐘 Action.php
│   │   │   │   │   ├── 🐘 AdminAppearance.php
│   │   │   │   │   ├── 🐘 AdminHelper.php
│   │   │   │   │   ├── 🐘 Assets.php
│   │   │   │   │   ├── 🐘 BaseHelper.php
│   │   │   │   │   ├── 🐘 Breadcrumb.php
│   │   │   │   │   ├── 🐘 Breadcrumbs.php
│   │   │   │   │   ├── 🐘 DashboardMenu.php
│   │   │   │   │   ├── 🐘 EmailHandler.php
│   │   │   │   │   ├── 🐘 Filter.php
│   │   │   │   │   ├── 🐘 Form.php
│   │   │   │   │   ├── 🐘 Html.php
│   │   │   │   │   ├── 🐘 MacroableModels.php
│   │   │   │   │   ├── 🐘 MetaBox.php
│   │   │   │   │   ├── 🐘 PageTitle.php
│   │   │   │   │   └── 🐘 PanelSectionManager.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 FieldOptions
│   │   │   │   │   │   ├── 🐘 AlertFieldOption.php
│   │   │   │   │   │   ├── 🐘 AutocompleteFieldOption.php
│   │   │   │   │   │   ├── 🐘 ButtonFieldOption.php
│   │   │   │   │   │   ├── 🐘 CheckboxFieldOption.php
│   │   │   │   │   │   ├── 🐘 CodeEditorFieldOption.php
│   │   │   │   │   │   ├── 🐘 ColorFieldOption.php
│   │   │   │   │   │   ├── 🐘 ColorSelectorFieldOption.php
│   │   │   │   │   │   ├── 🐘 ContentFieldOption.php
│   │   │   │   │   │   ├── 🐘 CoreIconFieldOption.php
│   │   │   │   │   │   ├── 🐘 DatePickerFieldOption.php
│   │   │   │   │   │   ├── 🐘 DescriptionFieldOption.php
│   │   │   │   │   │   ├── 🐘 EditorFieldOption.php
│   │   │   │   │   │   ├── 🐘 EmailFieldOption.php
│   │   │   │   │   │   ├── 🐘 FileFieldOption.php
│   │   │   │   │   │   ├── 🐘 HiddenFieldOption.php
│   │   │   │   │   │   ├── 🐘 HtmlFieldOption.php
│   │   │   │   │   │   ├── 🐘 ImageFieldOption.php
│   │   │   │   │   │   ├── 🐘 InputFieldOption.php
│   │   │   │   │   │   ├── 🐘 IsDefaultFieldOption.php
│   │   │   │   │   │   ├── 🐘 IsFeaturedFieldOption.php
│   │   │   │   │   │   ├── 🐘 LabelFieldOption.php
│   │   │   │   │   │   ├── 🐘 MediaFileFieldOption.php
│   │   │   │   │   │   ├── 🐘 MediaImageFieldOption.php
│   │   │   │   │   │   ├── 🐘 MediaImagesFieldOption.php
│   │   │   │   │   │   ├── 🐘 MultiChecklistFieldOption.php
│   │   │   │   │   │   ├── 🐘 NameFieldOption.php
│   │   │   │   │   │   ├── 🐘 NumberFieldOption.php
│   │   │   │   │   │   ├── 🐘 OnOffFieldOption.php
│   │   │   │   │   │   ├── 🐘 RadioFieldOption.php
│   │   │   │   │   │   ├── 🐘 RepeaterFieldOption.php
│   │   │   │   │   │   ├── 🐘 SelectFieldOption.php
│   │   │   │   │   │   ├── 🐘 SortOrderFieldOption.php
│   │   │   │   │   │   ├── 🐘 StatusFieldOption.php
│   │   │   │   │   │   ├── 🐘 TagFieldOption.php
│   │   │   │   │   │   ├── 🐘 TextFieldOption.php
│   │   │   │   │   │   ├── 🐘 TextareaFieldOption.php
│   │   │   │   │   │   ├── 🐘 TreeCategoryFieldOption.php
│   │   │   │   │   │   └── 🐘 UiSelectorFieldOption.php
│   │   │   │   │   ├── 📁 FieldTypes
│   │   │   │   │   │   ├── 🐘 ButtonGroupType.php
│   │   │   │   │   │   ├── 🐘 ButtonType.php
│   │   │   │   │   │   ├── 🐘 CheckableType.php
│   │   │   │   │   │   ├── 🐘 ChildFormType.php
│   │   │   │   │   │   ├── 🐘 ChoiceType.php
│   │   │   │   │   │   ├── 🐘 CollectionType.php
│   │   │   │   │   │   ├── 🐘 EntityType.php
│   │   │   │   │   │   ├── 🐘 FormField.php
│   │   │   │   │   │   ├── 🐘 InputType.php
│   │   │   │   │   │   ├── 🐘 ParentType.php
│   │   │   │   │   │   ├── 🐘 RepeatedType.php
│   │   │   │   │   │   ├── 🐘 SelectType.php
│   │   │   │   │   │   ├── 🐘 StaticType.php
│   │   │   │   │   │   └── 🐘 TextareaType.php
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   ├── 🐘 AlertField.php
│   │   │   │   │   │   ├── 🐘 AutocompleteField.php
│   │   │   │   │   │   ├── 🐘 CheckboxField.php
│   │   │   │   │   │   ├── 🐘 CkEditorField.php
│   │   │   │   │   │   ├── 🐘 CodeEditorField.php
│   │   │   │   │   │   ├── 🐘 ColorField.php
│   │   │   │   │   │   ├── 🐘 ColorSelectorField.php
│   │   │   │   │   │   ├── 🐘 CoreIconField.php
│   │   │   │   │   │   ├── 🐘 DateField.php
│   │   │   │   │   │   ├── 🐘 DatePickerField.php
│   │   │   │   │   │   ├── 🐘 DatetimeField.php
│   │   │   │   │   │   ├── 🐘 EditorField.php
│   │   │   │   │   │   ├── 🐘 EmailField.php
│   │   │   │   │   │   ├── 🐘 FileField.php
│   │   │   │   │   │   ├── 🐘 GoogleFontsField.php
│   │   │   │   │   │   ├── 🐘 HiddenField.php
│   │   │   │   │   │   ├── 🐘 HtmlField.php
│   │   │   │   │   │   ├── 🐘 LabelField.php
│   │   │   │   │   │   ├── 🐘 MediaFileField.php
│   │   │   │   │   │   ├── 🐘 MediaImageField.php
│   │   │   │   │   │   ├── 🐘 MediaImagesField.php
│   │   │   │   │   │   ├── 🐘 MultiCheckListField.php
│   │   │   │   │   │   ├── 🐘 NumberField.php
│   │   │   │   │   │   ├── 🐘 OnOffCheckboxField.php
│   │   │   │   │   │   ├── 🐘 OnOffField.php
│   │   │   │   │   │   ├── 🐘 PasswordField.php
│   │   │   │   │   │   ├── 🐘 PhoneNumberField.php
│   │   │   │   │   │   ├── 🐘 RadioField.php
│   │   │   │   │   │   ├── 🐘 RepeaterField.php
│   │   │   │   │   │   ├── 🐘 SelectField.php
│   │   │   │   │   │   ├── 🐘 TagField.php
│   │   │   │   │   │   ├── 🐘 TextField.php
│   │   │   │   │   │   ├── 🐘 TextareaField.php
│   │   │   │   │   │   ├── 🐘 TimeField.php
│   │   │   │   │   │   ├── 🐘 TimePickerField.php
│   │   │   │   │   │   ├── 🐘 TinyMceField.php
│   │   │   │   │   │   ├── 🐘 TreeCategoryField.php
│   │   │   │   │   │   └── 🐘 UiSelectorField.php
│   │   │   │   │   ├── 🐘 Form.php
│   │   │   │   │   ├── 🐘 FormAbstract.php
│   │   │   │   │   ├── 🐘 FormBuilder.php
│   │   │   │   │   ├── 🐘 FormCollapse.php
│   │   │   │   │   ├── 🐘 FormField.php
│   │   │   │   │   ├── 🐘 FormFieldOptions.php
│   │   │   │   │   ├── 🐘 FormHelper.php
│   │   │   │   │   ├── 🐘 FormTab.php
│   │   │   │   │   └── 🐘 MetaBox.php
│   │   │   │   ├── 📁 GlobalSearch
│   │   │   │   │   ├── 📁 Providers
│   │   │   │   │   │   ├── 🐘 DashboardMenuProvider.php
│   │   │   │   │   │   └── 🐘 PanelSectionProvider.php
│   │   │   │   │   ├── 🐘 GlobalSearchableManager.php
│   │   │   │   │   ├── 🐘 GlobalSearchableProvider.php
│   │   │   │   │   └── 🐘 GlobalSearchableResult.php
│   │   │   │   ├── 📁 Helpers
│   │   │   │   │   ├── 🐘 AdminHelper.php
│   │   │   │   │   ├── 🐘 BaseHelper.php
│   │   │   │   │   └── 🐘 ChartHelper.php
│   │   │   │   ├── 📁 Hooks
│   │   │   │   │   └── 🐘 EmailSettingHooks.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Actions
│   │   │   │   │   │   └── 🐘 DeleteResourceAction.php
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   │   ├── 🐘 HasBreadcrumb.php
│   │   │   │   │   │   │   ├── 🐘 HasHttpResponse.php
│   │   │   │   │   │   │   └── 🐘 HasPageTitle.php
│   │   │   │   │   │   ├── 🐘 BaseController.php
│   │   │   │   │   │   ├── 🐘 BaseSystemController.php
│   │   │   │   │   │   ├── 🐘 CacheManagementController.php
│   │   │   │   │   │   ├── 🐘 CoreIconController.php
│   │   │   │   │   │   ├── 🐘 CronjobSettingController.php
│   │   │   │   │   │   ├── 🐘 DebugModeController.php
│   │   │   │   │   │   ├── 🐘 NotificationController.php
│   │   │   │   │   │   ├── 🐘 SearchController.php
│   │   │   │   │   │   ├── 🐘 SecuritySettingController.php
│   │   │   │   │   │   ├── 🐘 SystemController.php
│   │   │   │   │   │   ├── 🐘 SystemInformationController.php
│   │   │   │   │   │   ├── 🐘 ToggleThemeModeController.php
│   │   │   │   │   │   └── 🐘 UnlicensedController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   ├── 🐘 AdminLocaleMiddleware.php
│   │   │   │   │   │   ├── 🐘 CoreMiddleware.php
│   │   │   │   │   │   ├── 🐘 DisableInDemoModeMiddleware.php
│   │   │   │   │   │   ├── 🐘 EnsureLicenseHasBeenActivated.php
│   │   │   │   │   │   ├── 🐘 HttpSecurityHeaders.php
│   │   │   │   │   │   ├── 🐘 HttpsProtocolMiddleware.php
│   │   │   │   │   │   ├── 🐘 LocaleMiddleware.php
│   │   │   │   │   │   └── 🐘 RequiresJsonRequestMiddleware.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   ├── 🐘 ClearCacheRequest.php
│   │   │   │   │   │   ├── 🐘 SelectSearchAjaxRequest.php
│   │   │   │   │   │   └── 🐘 UpdateTreeCategoryRequest.php
│   │   │   │   │   └── 📁 Responses
│   │   │   │   │       └── 🐘 BaseHttpResponse.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 AdminNotificationListener.php
│   │   │   │   │   ├── 🐘 BeforeEditContentListener.php
│   │   │   │   │   ├── 🐘 ClearDashboardMenuCaches.php
│   │   │   │   │   ├── 🐘 ClearDashboardMenuCachesForLoggedUser.php
│   │   │   │   │   ├── 🐘 CreatedContentListener.php
│   │   │   │   │   ├── 🐘 DeletedContentListener.php
│   │   │   │   │   ├── 🐘 PushDashboardMenuToSystemPanel.php
│   │   │   │   │   ├── 🐘 SendMailListener.php
│   │   │   │   │   └── 🐘 UpdatedContentListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   ├── 🐘 HasBaseEloquentBuilder.php
│   │   │   │   │   │   ├── 🐘 HasMetadata.php
│   │   │   │   │   │   ├── 🐘 HasSlug.php
│   │   │   │   │   │   └── 🐘 HasUuidsOrIntegerIds.php
│   │   │   │   │   ├── 🐘 AdminNotification.php
│   │   │   │   │   ├── 🐘 AdminNotificationQueryBuilder.php
│   │   │   │   │   ├── 🐘 BaseModel.php
│   │   │   │   │   ├── 🐘 BaseQueryBuilder.php
│   │   │   │   │   └── 🐘 MetaBox.php
│   │   │   │   ├── 📁 PanelSections
│   │   │   │   │   ├── 📁 System
│   │   │   │   │   │   └── 🐘 SystemPanelSection.php
│   │   │   │   │   ├── 🐘 Manager.php
│   │   │   │   │   ├── 🐘 PanelSection.php
│   │   │   │   │   └── 🐘 PanelSectionItem.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 BaseServiceProvider.php
│   │   │   │   │   ├── 🐘 BreadcrumbsServiceProvider.php
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 ComposerServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 FormServiceProvider.php
│   │   │   │   │   └── 🐘 MailConfigServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 MetaBoxCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 MetaBoxRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 MetaBoxInterface.php
│   │   │   │   ├── 📁 Rules
│   │   │   │   │   ├── 🐘 DomainRule.php
│   │   │   │   │   ├── 🐘 EmailRule.php
│   │   │   │   │   ├── 🐘 GoogleFontsRule.php
│   │   │   │   │   ├── 🐘 MediaImageRule.php
│   │   │   │   │   ├── 🐘 OnOffRule.php
│   │   │   │   │   └── 🐘 PhoneNumberRule.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   ├── 🐘 CleanDatabaseService.php
│   │   │   │   │   ├── 🐘 ClearCacheService.php
│   │   │   │   │   ├── 🐘 DeleteLocaleService.php
│   │   │   │   │   ├── 🐘 DeleteUnusedTranslationFilesService.php
│   │   │   │   │   └── 🐘 DownloadLocaleService.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   ├── 📁 Builders
│   │   │   │   │   │   ├── 🐘 Extensible.php
│   │   │   │   │   │   ├── 🐘 HasAttributes.php
│   │   │   │   │   │   ├── 🐘 HasColor.php
│   │   │   │   │   │   ├── 🐘 HasIcon.php
│   │   │   │   │   │   ├── 🐘 HasLabel.php
│   │   │   │   │   │   ├── 🐘 HasPermissions.php
│   │   │   │   │   │   ├── 🐘 HasUrl.php
│   │   │   │   │   │   └── 🐘 RenderingExtensible.php
│   │   │   │   │   ├── 📁 Database
│   │   │   │   │   │   └── 🐘 Blueprint.php
│   │   │   │   │   ├── 📁 HTMLPurifier
│   │   │   │   │   │   └── 📁 URIScheme
│   │   │   │   │   │       └── 🐘 ViberURIScheme.php
│   │   │   │   │   ├── 📁 ValueObjects
│   │   │   │   │   │   └── 🐘 CoreProduct.php
│   │   │   │   │   ├── 🐘 Action.php
│   │   │   │   │   ├── 🐘 ActionHookEvent.php
│   │   │   │   │   ├── 🐘 AdminAppearance.php
│   │   │   │   │   ├── 🐘 AdminNotificationItem.php
│   │   │   │   │   ├── 🐘 Assets.php
│   │   │   │   │   ├── 🐘 Avatar.php
│   │   │   │   │   ├── 🐘 BaseSeeder.php
│   │   │   │   │   ├── 🐘 Breadcrumb.php
│   │   │   │   │   ├── 🐘 BreadcrumbItem.php
│   │   │   │   │   ├── 🐘 BreadcrumbsGenerator.php
│   │   │   │   │   ├── 🐘 BreadcrumbsManager.php
│   │   │   │   │   ├── 🐘 Core.php
│   │   │   │   │   ├── 🐘 CustomResourceRegistrar.php
│   │   │   │   │   ├── 🐘 DashboardMenu.php
│   │   │   │   │   ├── 🐘 DashboardMenuItem.php
│   │   │   │   │   ├── 🐘 Database.php
│   │   │   │   │   ├── 🐘 Editor.php
│   │   │   │   │   ├── 🐘 EmailAbstract.php
│   │   │   │   │   ├── 🐘 EmailHandler.php
│   │   │   │   │   ├── 🐘 Enum.php
│   │   │   │   │   ├── 🐘 Filter.php
│   │   │   │   │   ├── 🐘 Fonts.php
│   │   │   │   │   ├── 🐘 GoogleFonts.php
│   │   │   │   │   ├── 🐘 Gravatar.php
│   │   │   │   │   ├── 🐘 Helper.php
│   │   │   │   │   ├── 🐘 MacroableModels.php
│   │   │   │   │   ├── 🐘 MembershipAuthorization.php
│   │   │   │   │   ├── 🐘 MenuPreloader.php
│   │   │   │   │   ├── 🐘 MetaBox.php
│   │   │   │   │   ├── 🐘 MetadataCache.php
│   │   │   │   │   ├── 🐘 PageTitle.php
│   │   │   │   │   ├── 🐘 PclZip.php
│   │   │   │   │   ├── 🐘 Pdf.php
│   │   │   │   │   ├── 🐘 Renderable.php
│   │   │   │   │   ├── 🐘 RepositoryHelper.php
│   │   │   │   │   ├── 🐘 ServiceProvider.php
│   │   │   │   │   ├── 🐘 SortItemsWithChildrenHelper.php
│   │   │   │   │   ├── 🐘 SystemManagement.php
│   │   │   │   │   ├── 🐘 TwigCompiler.php
│   │   │   │   │   ├── 🐘 TwigExtension.php
│   │   │   │   │   ├── 🐘 TwigLoader.php
│   │   │   │   │   └── 🐘 Zipper.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 InfoTable.php
│   │   │   │   ├── 📁 Traits
│   │   │   │   │   ├── 📁 FieldOptions
│   │   │   │   │   │   ├── 🐘 HasAspectRatio.php
│   │   │   │   │   │   ├── 🐘 HasCollapsibleField.php
│   │   │   │   │   │   └── 🐘 HasNumberItemsPerRow.php
│   │   │   │   │   ├── 📁 Forms
│   │   │   │   │   │   ├── 🐘 CanSpanColumns.php
│   │   │   │   │   │   ├── 🐘 HasCollapsible.php
│   │   │   │   │   │   ├── 🐘 HasColumns.php
│   │   │   │   │   │   ├── 🐘 HasFieldset.php
│   │   │   │   │   │   ├── 🐘 HasMetaBoxes.php
│   │   │   │   │   │   ├── 🐘 HasMetadata.php
│   │   │   │   │   │   └── 🐘 HasTabs.php
│   │   │   │   │   ├── 🐘 EnumCastable.php
│   │   │   │   │   ├── 🐘 HasDeleteManyItemsTrait.php
│   │   │   │   │   ├── 🐘 HasTreeCategory.php
│   │   │   │   │   └── 🐘 LoadAndPublishDataTrait.php
│   │   │   │   ├── 📁 View
│   │   │   │   │   └── 📁 Components
│   │   │   │   │       └── 🐘 BadgeComponent.php
│   │   │   │   ├── 📁 Widgets
│   │   │   │   │   ├── 📁 Contracts
│   │   │   │   │   │   └── 🐘 AdminWidget.php
│   │   │   │   │   ├── 🐘 AdminWidget.php
│   │   │   │   │   ├── 🐘 Card.php
│   │   │   │   │   ├── 🐘 Chart.php
│   │   │   │   │   ├── 🐘 Html.php
│   │   │   │   │   ├── 🐘 Table.php
│   │   │   │   │   └── 🐘 Widget.php
│   │   │   │   └── 📁 Ziggy
│   │   │   │       ├── 🐘 BladeRouteGenerator.php
│   │   │   │       └── 🐘 ZiggyServiceProvider.php
│   │   │   ├── 📁 tests
│   │   │   │   ├── 📁 Feature
│   │   │   │   │   ├── 🐘 CoreLicenseSystemTest.php
│   │   │   │   │   ├── 🐘 LicenseIntegrationTest.php
│   │   │   │   │   └── 🐘 LicenseSystemTest.php
│   │   │   │   ├── 📁 Unit
│   │   │   │   │   ├── 🐘 LicenseVerificationTest.php
│   │   │   │   │   └── 🐘 SystemControllerLicenseTest.php
│   │   │   │   ├── 🐘 BaseLicenseTestCase.php
│   │   │   │   └── 🐘 BaseTest.php
│   │   │   ├── ⚙️ package.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 chart
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 chart.blade.php
│   │   │   └── 📁 src
│   │   │       ├── 📁 Providers
│   │   │       │   └── 🐘 ChartServiceProvider.php
│   │   │       ├── 📁 Supports
│   │   │       │   ├── 🐘 Base.php
│   │   │       │   ├── 🐘 Chart.php
│   │   │       │   ├── 🐘 ChartBuilder.php
│   │   │       │   └── 🐘 ChartTypes.php
│   │   │       ├── 🐘 AreaChart.php
│   │   │       ├── 🐘 BarChart.php
│   │   │       ├── 🐘 DonutChart.php
│   │   │       └── 🐘 LineChart.php
│   │   ├── 📁 dashboard
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2016_11_28_032840_create_dashboard_widget_tables.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constant.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 dashboard.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 check-for-updates.js
│   │   │   │       └── 📄 dashboard.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📁 components
│   │   │   │   │   │   └── 📄 CheckForUpdates.vue
│   │   │   │   │   ├── 📄 check-for-updates.js
│   │   │   │   │   └── 📄 dashboard.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 modals.blade.php
│   │   │   │       │   ├── 🐘 no-data.blade.php
│   │   │   │       │   └── 🐘 paginate.blade.php
│   │   │   │       ├── 📁 widgets
│   │   │   │       │   ├── 🐘 base.blade.php
│   │   │   │       │   └── 🐘 stats.blade.php
│   │   │   │       └── 🐘 list.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 RenderingDashboardWidgets.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   └── 📁 Controllers
│   │   │   │   │       └── 🐘 DashboardController.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 DashboardWidget.php
│   │   │   │   │   └── 🐘 DashboardWidgetSetting.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 DashboardServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 DashboardWidgetCacheDecorator.php
│   │   │   │   │   │   └── 🐘 DashboardWidgetSettingCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 DashboardWidgetRepository.php
│   │   │   │   │   │   └── 🐘 DashboardWidgetSettingRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 DashboardWidgetInterface.php
│   │   │   │   │       └── 🐘 DashboardWidgetSettingInterface.php
│   │   │   │   └── 📁 Supports
│   │   │   │       └── 🐘 DashboardWidgetInstance.php
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 icon
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 icon.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 svg
│   │   │   └── 📁 src
│   │   │       ├── 📁 Commands
│   │   │       │   └── 🐘 IconUpdateCommand.php
│   │   │       ├── 📁 Exceptions
│   │   │       │   └── 🐘 SvgNotFoundException.php
│   │   │       ├── 📁 Facades
│   │   │       │   └── 🐘 Icon.php
│   │   │       ├── 📁 Providers
│   │   │       │   └── 🐘 IconServiceProvider.php
│   │   │       ├── 📁 View
│   │   │       │   └── 📁 Components
│   │   │       │       └── 🐘 Icon.php
│   │   │       ├── 🐘 IconDriver.php
│   │   │       ├── 🐘 IconManager.php
│   │   │       └── 🐘 SvgDriver.php
│   │   ├── 📁 js-validation
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 js-validation.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 js-validation.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📁 jquery-validation
│   │   │   │   │   │   └── 📄 jquery.validate.js
│   │   │   │   │   ├── 📁 php-date-formatter
│   │   │   │   │   │   └── 📄 php-date-formatter.js
│   │   │   │   │   ├── 📁 phpjs
│   │   │   │   │   │   ├── 📄 array_diff.js
│   │   │   │   │   │   ├── 📄 is_numeric.js
│   │   │   │   │   │   ├── 📄 strlen.js
│   │   │   │   │   │   └── 📄 strtotime.js
│   │   │   │   │   ├── 📄 helpers.js
│   │   │   │   │   ├── 📄 js-validation.js
│   │   │   │   │   ├── 📄 timezones.js
│   │   │   │   │   └── 📄 validations.js
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 bootstrap.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   └── 🐘 PropertyNotFoundException.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 JsValidator.php
│   │   │   │   ├── 📁 Javascript
│   │   │   │   │   ├── 🐘 JavascriptRulesTrait.php
│   │   │   │   │   ├── 🐘 JavascriptValidator.php
│   │   │   │   │   ├── 🐘 MessageParser.php
│   │   │   │   │   ├── 🐘 RuleParser.php
│   │   │   │   │   └── 🐘 ValidatorHandler.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 JsValidationServiceProvider.php
│   │   │   │   ├── 📁 Remote
│   │   │   │   │   ├── 🐘 Resolver.php
│   │   │   │   │   └── 🐘 Validator.php
│   │   │   │   ├── 📁 Support
│   │   │   │   │   ├── 🐘 AccessProtectedTrait.php
│   │   │   │   │   ├── 🐘 DelegatedValidator.php
│   │   │   │   │   ├── 🐘 RuleListTrait.php
│   │   │   │   │   ├── 🐘 UseDelegatedValidatorTrait.php
│   │   │   │   │   └── 🐘 ValidationRuleParserProxy.php
│   │   │   │   ├── 🐘 JsValidatorFactory.php
│   │   │   │   └── 🐘 RemoteValidationMiddleware.php
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 media
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 media.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2017_05_09_070343_create_media_tables.php
│   │   │   │       ├── 🐘 2022_04_20_100851_add_index_to_media_table.php
│   │   │   │       ├── 🐘 2023_01_30_024431_add_alt_to_media_table.php
│   │   │   │       ├── 🐘 2023_12_07_095130_add_color_column_to_media_folders_table.php
│   │   │   │       ├── 🐘 2023_12_17_162208_make_sure_column_color_in_media_folders_nullable.php
│   │   │   │       ├── 🐘 2024_05_12_091229_add_column_visibility_to_table_media_files.php
│   │   │   │       └── 🐘 2024_07_12_100000_change_random_hash_for_media.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 common.php
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 media.css
│   │   │   │   ├── 📁 images
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 integrate.js
│   │   │   │   │   └── 📄 media.js
│   │   │   │   └── 📁 libraries
│   │   │   │       ├── 📁 jquery-context-menu
│   │   │   │       │   └── 📁 font
│   │   │   │       │       ├── 📄 context-menu-icons.eot
│   │   │   │       │       └── 📄 context-menu-icons.woff
│   │   │   │       └── 📁 lodash
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📁 App
│   │   │   │   │   │   ├── 📁 Config
│   │   │   │   │   │   │   └── 📄 MediaConfig.js
│   │   │   │   │   │   ├── 📁 Helpers
│   │   │   │   │   │   │   └── 📄 Helpers.js
│   │   │   │   │   │   ├── 📁 Services
│   │   │   │   │   │   │   ├── 📄 ActionsService.js
│   │   │   │   │   │   │   ├── 📄 ContextMenuService.js
│   │   │   │   │   │   │   ├── 📄 DownloadService.js
│   │   │   │   │   │   │   ├── 📄 FolderService.js
│   │   │   │   │   │   │   ├── 📄 MediaService.js
│   │   │   │   │   │   │   ├── 📄 MessageService.js
│   │   │   │   │   │   │   └── 📄 UploadService.js
│   │   │   │   │   │   └── 📁 Views
│   │   │   │   │   │       ├── 📄 MediaDetails.js
│   │   │   │   │   │       └── 📄 MediaList.js
│   │   │   │   │   ├── 📄 integrate.js
│   │   │   │   │   ├── 📄 jquery.doubletap.js
│   │   │   │   │   └── 📄 media.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   ├── 📁 components
│   │   │   │   │   │   ├── 🎨 _block.scss
│   │   │   │   │   │   ├── 🎨 _breadcrumb.scss
│   │   │   │   │   │   ├── 🎨 _components.scss
│   │   │   │   │   │   ├── 🎨 _input.scss
│   │   │   │   │   │   ├── 🎨 _progress.scss
│   │   │   │   │   │   ├── 🎨 _thumbnail.scss
│   │   │   │   │   │   ├── 🎨 _typography.scss
│   │   │   │   │   │   ├── 🎨 _upload-progress.scss
│   │   │   │   │   │   └── 🎨 _utilities.scss
│   │   │   │   │   ├── 📁 layouts
│   │   │   │   │   │   ├── 🎨 _content.scss
│   │   │   │   │   │   ├── 🎨 _footer.scss
│   │   │   │   │   │   ├── 🎨 _header.scss
│   │   │   │   │   │   ├── 🎨 _layouts.scss
│   │   │   │   │   │   └── 🎨 _media-list.scss
│   │   │   │   │   ├── 📁 mixins
│   │   │   │   │   │   ├── 🎨 _layout.scss
│   │   │   │   │   │   ├── 🎨 _mixins.scss
│   │   │   │   │   │   ├── 🎨 _shape.scss
│   │   │   │   │   │   └── 🎨 _support.scss
│   │   │   │   │   ├── 📁 variables
│   │   │   │   │   │   ├── 🎨 _breakpoints.scss
│   │   │   │   │   │   ├── 🎨 _colors.scss
│   │   │   │   │   │   ├── 🎨 _font-awesome.scss
│   │   │   │   │   │   └── 🎨 _variables.scss
│   │   │   │   │   ├── 🎨 _cropper.scss
│   │   │   │   │   ├── 🎨 _integrate.scss
│   │   │   │   │   └── 🎨 media.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   └── 🐘 media.blade.php
│   │   │   │       ├── 🐘 config.blade.php
│   │   │   │       ├── 🐘 content.blade.php
│   │   │   │       ├── 🐘 footer.blade.php
│   │   │   │       ├── 🐘 header.blade.php
│   │   │   │       ├── 🐘 index.blade.php
│   │   │   │       └── 🐘 popup.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Chunks
│   │   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   │   ├── 🐘 ChunkSaveException.php
│   │   │   │   │   │   ├── 🐘 MissingChunkFilesException.php
│   │   │   │   │   │   ├── 🐘 UploadFailedException.php
│   │   │   │   │   │   └── 🐘 UploadMissingFileException.php
│   │   │   │   │   ├── 📁 Handler
│   │   │   │   │   │   ├── 🐘 AbstractHandler.php
│   │   │   │   │   │   └── 🐘 DropZoneUploadHandler.php
│   │   │   │   │   ├── 📁 Receiver
│   │   │   │   │   │   └── 🐘 FileReceiver.php
│   │   │   │   │   ├── 📁 Save
│   │   │   │   │   │   ├── 🐘 AbstractSave.php
│   │   │   │   │   │   ├── 🐘 ChunkSave.php
│   │   │   │   │   │   └── 🐘 ParallelSave.php
│   │   │   │   │   ├── 📁 Storage
│   │   │   │   │   │   └── 🐘 ChunkStorage.php
│   │   │   │   │   ├── 🐘 ChunkFile.php
│   │   │   │   │   └── 🐘 FileMerger.php
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 ClearChunksCommand.php
│   │   │   │   │   ├── 🐘 CropImageCommand.php
│   │   │   │   │   ├── 🐘 DeleteThumbnailCommand.php
│   │   │   │   │   ├── 🐘 GenerateThumbnailCommand.php
│   │   │   │   │   └── 🐘 InsertWatermarkCommand.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 MediaFileRenamed.php
│   │   │   │   │   ├── 🐘 MediaFileRenaming.php
│   │   │   │   │   ├── 🐘 MediaFileUploaded.php
│   │   │   │   │   ├── 🐘 MediaFolderRenamed.php
│   │   │   │   │   └── 🐘 MediaFolderRenaming.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 AppMedia.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 MediaController.php
│   │   │   │   │   │   ├── 🐘 MediaFileController.php
│   │   │   │   │   │   ├── 🐘 MediaFolderController.php
│   │   │   │   │   │   └── 🐘 PublicMediaController.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   ├── 🐘 MediaFolderRequest.php
│   │   │   │   │   │   └── 🐘 MediaListRequest.php
│   │   │   │   │   └── 📁 Resources
│   │   │   │   │       ├── 🐘 FileResource.php
│   │   │   │   │       └── 🐘 FolderResource.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 MediaFile.php
│   │   │   │   │   ├── 🐘 MediaFolder.php
│   │   │   │   │   └── 🐘 MediaSetting.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 MediaServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 MediaFileCacheDecorator.php
│   │   │   │   │   │   ├── 🐘 MediaFolderCacheDecorator.php
│   │   │   │   │   │   └── 🐘 MediaSettingCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 MediaFileRepository.php
│   │   │   │   │   │   ├── 🐘 MediaFolderRepository.php
│   │   │   │   │   │   └── 🐘 MediaSettingRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 MediaFileInterface.php
│   │   │   │   │       ├── 🐘 MediaFolderInterface.php
│   │   │   │   │       └── 🐘 MediaSettingInterface.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   ├── 🐘 ThumbnailService.php
│   │   │   │   │   └── 🐘 UploadsManager.php
│   │   │   │   ├── 📁 Storage
│   │   │   │   │   └── 📁 BunnyCDN
│   │   │   │   │       ├── 📁 Exceptions
│   │   │   │   │       │   ├── 🐘 BunnyCDNException.php
│   │   │   │   │       │   ├── 🐘 DirectoryNotEmptyException.php
│   │   │   │   │       │   └── 🐘 NotFoundException.php
│   │   │   │   │       ├── 🐘 BunnyCDNAdapter.php
│   │   │   │   │       ├── 🐘 BunnyCDNClient.php
│   │   │   │   │       ├── 🐘 BunnyCDNRegion.php
│   │   │   │   │       └── 🐘 Util.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   ├── 🐘 ZipRepository.php
│   │   │   │   │   ├── 🐘 Zipper.php
│   │   │   │   │   └── 🐘 ZipperInterface.php
│   │   │   │   └── 🐘 AppMedia.php
│   │   │   ├── ⚙️ package.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 setting
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 email.php
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2016_10_05_074239_create_setting_table.php
│   │   │   │       └── 🐘 2022_11_18_063357_add_missing_timestamp_in_table_settings.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 admin-email.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 admin-email.js
│   │   │   │       ├── 📄 cronjob.js
│   │   │   │       ├── 📄 email-template.js
│   │   │   │       ├── 📄 email.js
│   │   │   │       ├── 📄 license-component.js
│   │   │   │       └── 📄 media.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 email-templates
│   │   │   │   │   └── 📄 test.tpl
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📁 components
│   │   │   │   │   │   └── 📄 LicenseForm.vue
│   │   │   │   │   ├── 📄 admin-email.js
│   │   │   │   │   ├── 📄 email-template.js
│   │   │   │   │   ├── 📄 email.js
│   │   │   │   │   ├── 📄 license-component.js
│   │   │   │   │   └── 📄 media.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 admin-email.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 components
│   │   │   │       │   ├── 📁 section
│   │   │   │       │   │   └── 📁 action
│   │   │   │       │   │       ├── 🐘 index.blade.php
│   │   │   │       │   │       └── 🐘 save.blade.php
│   │   │   │       │   ├── 🐘 checkbox.blade.php
│   │   │   │       │   ├── 🐘 form-group.blade.php
│   │   │   │       │   ├── 🐘 on-off.blade.php
│   │   │   │       │   ├── 🐘 radio.blade.php
│   │   │   │       │   ├── 🐘 section.blade.php
│   │   │   │       │   ├── 🐘 select.blade.php
│   │   │   │       │   ├── 🐘 text-input.blade.php
│   │   │   │       │   └── 🐘 textarea.blade.php
│   │   │   │       ├── 📁 forms
│   │   │   │       │   ├── 📁 partials
│   │   │   │       │   │   └── 🐘 action.blade.php
│   │   │   │       │   ├── 🐘 form-content-only.blade.php
│   │   │   │       │   └── 🐘 form.blade.php
│   │   │   │       ├── 📁 includes
│   │   │   │       │   └── 🐘 form-media-size-label.blade.php
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 📁 email
│   │   │   │       │   │   └── 🐘 action-buttons.blade.php
│   │   │   │       │   ├── 📁 media
│   │   │   │       │   │   ├── 🐘 action-buttons.blade.php
│   │   │   │       │   │   ├── 🐘 chunk-size-upload-field.blade.php
│   │   │   │       │   │   └── 🐘 media-folders-can-add-watermark-field.blade.php
│   │   │   │       │   ├── 🐘 admin-email-field.blade.php
│   │   │   │       │   └── 🐘 license.blade.php
│   │   │   │       ├── 🐘 cronjob.blade.php
│   │   │   │       ├── 🐘 email-template-edit.blade.php
│   │   │   │       ├── 🐘 email-templates.blade.php
│   │   │   │       ├── 🐘 email.blade.php
│   │   │   │       ├── 🐘 general.blade.php
│   │   │   │       ├── 🐘 index.blade.php
│   │   │   │       ├── 🐘 media.blade.php
│   │   │   │       ├── 🐘 preview-email.blade.php
│   │   │   │       ├── 🐘 security.blade.php
│   │   │   │       ├── 🐘 template-line.blade.php
│   │   │   │       └── 🐘 template-on-off.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   └── 🐘 CronJobTestCommand.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 DataRetentionPeriod.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 Setting.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 🐘 AdminAppearanceSettingForm.php
│   │   │   │   │   ├── 🐘 CacheSettingForm.php
│   │   │   │   │   ├── 🐘 DataTableSettingForm.php
│   │   │   │   │   ├── 🐘 EmailRulesSettingForm.php
│   │   │   │   │   ├── 🐘 EmailSettingForm.php
│   │   │   │   │   ├── 🐘 EmailTemplateSettingForm.php
│   │   │   │   │   ├── 🐘 GeneralSettingForm.php
│   │   │   │   │   ├── 🐘 MediaSettingForm.php
│   │   │   │   │   └── 🐘 SettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   │   └── 🐘 InteractsWithSettings.php
│   │   │   │   │   │   ├── 🐘 AdminAppearanceSettingController.php
│   │   │   │   │   │   ├── 🐘 CacheSettingController.php
│   │   │   │   │   │   ├── 🐘 DataTableSettingController.php
│   │   │   │   │   │   ├── 🐘 EmailRuleSettingController.php
│   │   │   │   │   │   ├── 🐘 EmailSettingController.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateController.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateIframeController.php
│   │   │   │   │   │   ├── 🐘 EmailTemplatePreviewController.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateRestoreController.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateSettingController.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateStatusController.php
│   │   │   │   │   │   ├── 🐘 EmailTestController.php
│   │   │   │   │   │   ├── 🐘 GeneralSettingController.php
│   │   │   │   │   │   ├── 🐘 HomeSettingController.php
│   │   │   │   │   │   ├── 🐘 MediaSettingController.php
│   │   │   │   │   │   └── 🐘 SettingController.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   ├── 🐘 AdminAppearanceRequest.php
│   │   │   │   │   │   ├── 🐘 CacheSettingRequest.php
│   │   │   │   │   │   ├── 🐘 DataTableSettingRequest.php
│   │   │   │   │   │   ├── 🐘 EmailRulesSettingRequest.php
│   │   │   │   │   │   ├── 🐘 EmailSendTestRequest.php
│   │   │   │   │   │   ├── 🐘 EmailSettingRequest.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateChangeStatusRequest.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateRequest.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateRestoreRequest.php
│   │   │   │   │   │   ├── 🐘 EmailTemplateSettingRequest.php
│   │   │   │   │   │   ├── 🐘 GeneralSettingRequest.php
│   │   │   │   │   │   ├── 🐘 LicenseSettingRequest.php
│   │   │   │   │   │   ├── 🐘 MediaSettingRequest.php
│   │   │   │   │   │   └── 🐘 SettingRequest.php
│   │   │   │   │   └── 📁 Traits
│   │   │   │   │       └── 🐘 GetEmailTemplateDataTrait.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 PushDashboardMenuToOtherSectionPanel.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 Setting.php
│   │   │   │   ├── 📁 PanelSections
│   │   │   │   │   ├── 🐘 SettingCommonPanelSection.php
│   │   │   │   │   └── 🐘 SettingOthersPanelSection.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 SettingServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 SettingCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 SettingRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 SettingInterface.php
│   │   │   │   ├── 📁 Rules
│   │   │   │   │   └── 🐘 AwsRegionRule.php
│   │   │   │   └── 📁 Supports
│   │   │   │       ├── 🐘 DatabaseSettingStore.php
│   │   │   │       └── 🐘 SettingStore.php
│   │   │   ├── 📁 tests
│   │   │   │   └── 📁 Feature
│   │   │   │       └── 🐘 GeneralSettingLicenseTest.php
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 support
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 common.php
│   │   │   └── 📁 src
│   │   │       ├── 📁 Http
│   │   │       │   ├── 📁 Middleware
│   │   │       │   │   └── 🐘 BaseMiddleware.php
│   │   │       │   └── 📁 Requests
│   │   │       │       └── 🐘 Request.php
│   │   │       ├── 📁 Providers
│   │   │       │   └── 🐘 SupportServiceProvider.php
│   │   │       ├── 📁 Repositories
│   │   │       │   ├── 📁 Caches
│   │   │       │   │   └── 🐘 CacheAbstractDecorator.php
│   │   │       │   ├── 📁 Eloquent
│   │   │       │   │   └── 🐘 RepositoriesAbstract.php
│   │   │       │   └── 📁 Interfaces
│   │   │       │       └── 🐘 RepositoryInterface.php
│   │   │       └── 📁 Services
│   │   │           └── 🐘 ProduceServiceInterface.php
│   │   ├── 📁 table
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 common.php
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 table.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 filter.js
│   │   │   │       └── 📄 table.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 filter.js
│   │   │   │   │   └── 📄 table.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 table.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 actions
│   │   │   │       │   ├── 📁 includes
│   │   │   │       │   │   ├── 🐘 action-attributes.blade.php
│   │   │   │       │   │   └── 🐘 action-icon.blade.php
│   │   │   │       │   ├── 🐘 action-dropdown-item.blade.php
│   │   │   │       │   └── 🐘 action.blade.php
│   │   │   │       ├── 📁 cells
│   │   │   │       │   ├── 🐘 copyable.blade.php
│   │   │   │       │   └── 🐘 icon.blade.php
│   │   │   │       ├── 📁 includes
│   │   │   │       │   ├── 📁 columns
│   │   │   │       │   │   └── 🐘 yes-no.blade.php
│   │   │   │       │   └── 🐘 header-action.blade.php
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 actions.blade.php
│   │   │   │       │   ├── 🐘 checkbox.blade.php
│   │   │   │       │   └── 🐘 create.blade.php
│   │   │   │       ├── 🐘 base-table.blade.php
│   │   │   │       ├── 🐘 bulk-action.blade.php
│   │   │   │       ├── 🐘 bulk-changes.blade.php
│   │   │   │       ├── 🐘 editor.blade.php
│   │   │   │       ├── 🐘 filter.blade.php
│   │   │   │       ├── 🐘 modal.blade.php
│   │   │   │       ├── 🐘 row-actions.blade.php
│   │   │   │       ├── 🐘 script.blade.php
│   │   │   │       ├── 🐘 simple-table.blade.php
│   │   │   │       ├── 🐘 table-info.blade.php
│   │   │   │       └── 🐘 table.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   ├── 🐘 web-actions.php
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Abstracts
│   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   ├── 🐘 DeprecatedFunctions.php
│   │   │   │   │   │   ├── 🐘 HasActions.php
│   │   │   │   │   │   ├── 🐘 HasBulkActions.php
│   │   │   │   │   │   ├── 🐘 HasColumnVisibility.php
│   │   │   │   │   │   ├── 🐘 HasConfirmation.php
│   │   │   │   │   │   ├── 🐘 HasFilters.php
│   │   │   │   │   │   ├── 🐘 HasHeaderActions.php
│   │   │   │   │   │   └── 🐘 HasPriority.php
│   │   │   │   │   ├── 🐘 TableAbstract.php
│   │   │   │   │   ├── 🐘 TableActionAbstract.php
│   │   │   │   │   ├── 🐘 TableBulkActionAbstract.php
│   │   │   │   │   └── 🐘 TableBulkChangeAbstract.php
│   │   │   │   ├── 📁 Actions
│   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   └── 🐘 HasAction.php
│   │   │   │   │   ├── 🐘 Action.php
│   │   │   │   │   ├── 🐘 DeleteAction.php
│   │   │   │   │   ├── 🐘 EditAction.php
│   │   │   │   │   └── 🐘 ViewAction.php
│   │   │   │   ├── 📁 BulkActions
│   │   │   │   │   └── 🐘 DeleteBulkAction.php
│   │   │   │   ├── 📁 BulkChanges
│   │   │   │   │   ├── 🐘 CreatedAtBulkChange.php
│   │   │   │   │   ├── 🐘 DateBulkChange.php
│   │   │   │   │   ├── 🐘 EmailBulkChange.php
│   │   │   │   │   ├── 🐘 IsFeaturedBulkChange.php
│   │   │   │   │   ├── 🐘 NameBulkChange.php
│   │   │   │   │   ├── 🐘 NumberBulkChange.php
│   │   │   │   │   ├── 🐘 PhoneBulkChange.php
│   │   │   │   │   ├── 🐘 SelectBulkChange.php
│   │   │   │   │   ├── 🐘 StatusBulkChange.php
│   │   │   │   │   └── 🐘 TextBulkChange.php
│   │   │   │   ├── 📁 Columns
│   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   ├── 🐘 Blurrable.php
│   │   │   │   │   │   ├── 🐘 Copyable.php
│   │   │   │   │   │   ├── 🐘 CopyableAction.php
│   │   │   │   │   │   ├── 🐘 CopyablePosition.php
│   │   │   │   │   │   ├── 🐘 HasColor.php
│   │   │   │   │   │   ├── 🐘 HasEmptyState.php
│   │   │   │   │   │   ├── 🐘 HasIcon.php
│   │   │   │   │   │   ├── 🐘 HasLink.php
│   │   │   │   │   │   ├── 🐘 HasStyle.php
│   │   │   │   │   │   ├── 🐘 IconPosition.php
│   │   │   │   │   │   └── 🐘 Maskable.php
│   │   │   │   │   ├── 🐘 CheckboxColumn.php
│   │   │   │   │   ├── 🐘 Column.php
│   │   │   │   │   ├── 🐘 CreatedAtColumn.php
│   │   │   │   │   ├── 🐘 DateColumn.php
│   │   │   │   │   ├── 🐘 DateTimeColumn.php
│   │   │   │   │   ├── 🐘 EmailColumn.php
│   │   │   │   │   ├── 🐘 EnumColumn.php
│   │   │   │   │   ├── 🐘 FormattedColumn.php
│   │   │   │   │   ├── 🐘 IdColumn.php
│   │   │   │   │   ├── 🐘 ImageColumn.php
│   │   │   │   │   ├── 🐘 LinkableColumn.php
│   │   │   │   │   ├── 🐘 NameColumn.php
│   │   │   │   │   ├── 🐘 PhoneColumn.php
│   │   │   │   │   ├── 🐘 RowActionsColumn.php
│   │   │   │   │   ├── 🐘 StatusColumn.php
│   │   │   │   │   ├── 🐘 UpdatedAtColumn.php
│   │   │   │   │   └── 🐘 YesNoColumn.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   └── 🐘 FormattedColumn.php
│   │   │   │   ├── 📁 HeaderActions
│   │   │   │   │   ├── 🐘 CreateHeaderAction.php
│   │   │   │   │   └── 🐘 HeaderAction.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 TableBulkActionController.php
│   │   │   │   │   │   ├── 🐘 TableBulkChangeController.php
│   │   │   │   │   │   ├── 🐘 TableColumnVisibilityController.php
│   │   │   │   │   │   ├── 🐘 TableController.php
│   │   │   │   │   │   └── 🐘 TableFilterController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 BulkChangeRequest.php
│   │   │   │   │       ├── 🐘 DispatchBulkActionRequest.php
│   │   │   │   │       ├── 🐘 FilterRequest.php
│   │   │   │   │       └── 🐘 SaveBulkChangeRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 TableServiceProvider.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   ├── 🐘 Builder.php
│   │   │   │   │   └── 🐘 TableExportHandler.php
│   │   │   │   ├── 🐘 ApiResourceDataTable.php
│   │   │   │   ├── 🐘 CollectionDataTable.php
│   │   │   │   ├── 🐘 DataTables.php
│   │   │   │   ├── 🐘 EloquentDataTable.php
│   │   │   │   ├── 🐘 Formatter.php
│   │   │   │   ├── 🐘 QueryDataTable.php
│   │   │   │   └── 🐘 TableBuilder.php
│   │   │   └── 📄 webpack.mix.js
│   │   ├── ⚙️ composer.json
│   │   └── ⚙️ core.json
│   ├── 📁 libs
│   │   ├── 📁 api
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 api.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2022_08_04_051940_add_missing_column_expires_at.php
│   │   │   │       ├── 🐘 2024_12_19_000001_create_device_tokens_table.php
│   │   │   │       ├── 🐘 2024_12_19_000002_create_push_notifications_table.php
│   │   │   │       ├── 🐘 2024_12_19_000003_create_push_notification_recipients_table.php
│   │   │   │       └── 🐘 2024_12_30_000001_create_user_settings_table.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 api-settings.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 api-settings.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 api-settings.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 api-settings.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 settings
│   │   │   │       │   └── 📁 partials
│   │   │   │       │       ├── 🐘 api-key-actions.blade.php
│   │   │   │       │       ├── 🐘 api-key-field.blade.php
│   │   │   │       │       ├── 🐘 documentation-section.blade.php
│   │   │   │       │       ├── 🐘 fcm-service-account-field.blade.php
│   │   │   │       │       ├── 🐘 fcm-setup-instructions.blade.php
│   │   │   │       │       ├── 🐘 send-notification-form.blade.php
│   │   │   │       │       └── 🐘 usage-examples.blade.php
│   │   │   │       ├── 🐘 settings.blade.php
│   │   │   │       └── 🐘 table.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   ├── 🐘 api.php
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 GenerateDocumentationCommand.php
│   │   │   │   │   ├── 🐘 ProcessScheduledNotificationsCommand.php
│   │   │   │   │   ├── 📝 README.md
│   │   │   │   │   └── 🐘 SendPushNotificationCommand.php
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Seeders
│   │   │   │   │       ├── 🐘 ApiDatabaseSeeder.php
│   │   │   │   │       ├── 🐘 DeviceTokenSeeder.php
│   │   │   │   │       ├── 🐘 PersonalAccessTokenSeeder.php
│   │   │   │   │       ├── 🐘 PushNotificationSeeder.php
│   │   │   │   │       └── 🐘 UserSettingSeeder.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 ApiHelper.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   └── 🐘 ApiSettingForm.php
│   │   │   │   │   └── 🐘 SanctumTokenForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 ApiController.php
│   │   │   │   │   │   ├── 🐘 AuthenticationController.php
│   │   │   │   │   │   ├── 🐘 BaseApiController.php
│   │   │   │   │   │   ├── 🐘 DeviceTokenController.php
│   │   │   │   │   │   ├── 🐘 ForgotPasswordController.php
│   │   │   │   │   │   ├── 🐘 NotificationController.php
│   │   │   │   │   │   ├── 🐘 ProfileController.php
│   │   │   │   │   │   ├── 🐘 SanctumTokenController.php
│   │   │   │   │   │   └── 🐘 VerificationController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   ├── 🐘 ApiEnabledMiddleware.php
│   │   │   │   │   │   ├── 🐘 ApiKeyMiddleware.php
│   │   │   │   │   │   └── 🐘 ForceJsonResponseMiddleware.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   ├── 🐘 ApiRequest.php
│   │   │   │   │   │   ├── 🐘 ApiSettingRequest.php
│   │   │   │   │   │   ├── 🐘 CheckEmailRequest.php
│   │   │   │   │   │   ├── 🐘 DeviceTokenRequest.php
│   │   │   │   │   │   ├── 🐘 ForgotPasswordRequest.php
│   │   │   │   │   │   ├── 🐘 RegisterRequest.php
│   │   │   │   │   │   ├── 🐘 ResendEmailVerificationRequest.php
│   │   │   │   │   │   ├── 🐘 SendNotificationRequest.php
│   │   │   │   │   │   ├── 🐘 StoreSanctumTokenRequest.php
│   │   │   │   │   │   ├── 🐘 UpdateUserSettingsRequest.php
│   │   │   │   │   │   └── 🐘 VerifyEmailRequest.php
│   │   │   │   │   └── 📁 Resources
│   │   │   │   │       └── 🐘 UserResource.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 DeviceToken.php
│   │   │   │   │   ├── 🐘 PersonalAccessToken.php
│   │   │   │   │   ├── 🐘 PushNotification.php
│   │   │   │   │   ├── 🐘 PushNotificationRecipient.php
│   │   │   │   │   └── 🐘 UserSetting.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 ApiServiceProvider.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 PushNotificationService.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   └── 🐘 ApiHelper.php
│   │   │   │   └── 📁 Tables
│   │   │   │       └── 🐘 SanctumTokenTable.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 assets
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 assets.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 footer.blade.php
│   │   │   │       └── 🐘 header.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 AssetsFacade.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 AssetsServiceProvider.php
│   │   │   │   ├── 🐘 Assets.php
│   │   │   │   └── 🐘 HtmlBuilder.php
│   │   │   ├── ⚙️ .styleci.yml
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📝 LICENSE.md
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ phpunit.xml
│   │   │   └── ⚙️ scrutinizer.yml
│   │   ├── 📁 data-synchronize
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 data-synchronize.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 data-synchronize.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 data-synchronize.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 data-synchronize.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 data-synchronize.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 empty-state.blade.php
│   │   │   │       │   ├── 🐘 example.blade.php
│   │   │   │       │   ├── 🐘 importer.blade.php
│   │   │   │       │   └── 🐘 rules.blade.php
│   │   │   │       ├── 🐘 data-synchronize.blade.php
│   │   │   │       ├── 🐘 export.blade.php
│   │   │   │       └── 🐘 import.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 ClearChunksCommand.php
│   │   │   │   │   ├── 🐘 ExportCommand.php
│   │   │   │   │   ├── 🐘 ExportControllerMakeCommand.php
│   │   │   │   │   ├── 🐘 ExporterMakeCommand.php
│   │   │   │   │   ├── 🐘 GeneratorCommand.php
│   │   │   │   │   ├── 🐘 ImportCommand.php
│   │   │   │   │   ├── 🐘 ImportControllerMakeCommand.php
│   │   │   │   │   ├── 🐘 ImporterMakeCommand.php
│   │   │   │   │   └── 🐘 TestLargeExportCommand.php
│   │   │   │   ├── 📁 Concerns
│   │   │   │   │   ├── 📁 Exporter
│   │   │   │   │   │   └── 🐘 HasEmptyState.php
│   │   │   │   │   └── 📁 Importer
│   │   │   │   │       └── 🐘 HasImportResults.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   └── 📁 Importer
│   │   │   │   │       └── 🐘 WithMapping.php
│   │   │   │   ├── 📁 DataTransferObjects
│   │   │   │   │   ├── 🐘 ChunkImportResponse.php
│   │   │   │   │   ├── 🐘 ChunkResponse.php
│   │   │   │   │   └── 🐘 ChunkValidateResponse.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 ExportColumnType.php
│   │   │   │   ├── 📁 Exporter
│   │   │   │   │   ├── 🐘 ExampleExporter.php
│   │   │   │   │   ├── 🐘 ExportColumn.php
│   │   │   │   │   ├── 🐘 ExportCounter.php
│   │   │   │   │   └── 🐘 Exporter.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 DataSynchronizeController.php
│   │   │   │   │   │   ├── 🐘 ExportController.php
│   │   │   │   │   │   ├── 🐘 ImportController.php
│   │   │   │   │   │   └── 🐘 UploadController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 DownloadTemplateRequest.php
│   │   │   │   │       ├── 🐘 ExportRequest.php
│   │   │   │   │       └── 🐘 ImportRequest.php
│   │   │   │   ├── 📁 Importer
│   │   │   │   │   ├── 🐘 ImportColumn.php
│   │   │   │   │   └── 🐘 Importer.php
│   │   │   │   ├── 📁 PanelSections
│   │   │   │   │   ├── 🐘 ExportPanelSection.php
│   │   │   │   │   └── 🐘 ImportPanelSection.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 DataSynchronizeServiceProvider.php
│   │   │   │   └── 📁 Table
│   │   │   │       └── 📁 HeaderActions
│   │   │   │           ├── 🐘 ExportHeaderAction.php
│   │   │   │           └── 🐘 ImportHeaderAction.php
│   │   │   ├── 📁 stubs
│   │   │   │   ├── 📄 export-controller.stub
│   │   │   │   ├── 📄 exporter.stub
│   │   │   │   ├── 📄 import-controller.stub
│   │   │   │   └── 📄 importer.stub
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 dev-tool
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 assets
│   │   │   │       └── 📁 images
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 📁 Abstracts
│   │   │   │   │   │   └── 🐘 BaseMakeCommand.php
│   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   ├── 🐘 HasModuleSelector.php
│   │   │   │   │   │   └── 🐘 HasSubModule.php
│   │   │   │   │   ├── 📁 Make
│   │   │   │   │   │   ├── 🐘 ControllerMakeCommand.php
│   │   │   │   │   │   ├── 🐘 FormMakeCommand.php
│   │   │   │   │   │   ├── 🐘 ModelMakeCommand.php
│   │   │   │   │   │   ├── 🐘 PanelSectionMakeCommand.php
│   │   │   │   │   │   ├── 🐘 RequestMakeCommand.php
│   │   │   │   │   │   ├── 🐘 RouteMakeCommand.php
│   │   │   │   │   │   ├── 🐘 SettingControllerMakeCommand.php
│   │   │   │   │   │   ├── 🐘 SettingFormMakeCommand.php
│   │   │   │   │   │   ├── 🐘 SettingMakeCommand.php
│   │   │   │   │   │   ├── 🐘 SettingRequestMakeCommand.php
│   │   │   │   │   │   └── 🐘 TableMakeCommand.php
│   │   │   │   │   ├── 🐘 LocaleCreateCommand.php
│   │   │   │   │   ├── 🐘 LocaleRemoveCommand.php
│   │   │   │   │   ├── 🐘 PackageCreateCommand.php
│   │   │   │   │   ├── 🐘 PackageMakeCrudCommand.php
│   │   │   │   │   ├── 🐘 PackageRemoveCommand.php
│   │   │   │   │   ├── 🐘 PluginCreateCommand.php
│   │   │   │   │   ├── 🐘 PluginMakeCrudCommand.php
│   │   │   │   │   ├── 🐘 RebuildPermissionsCommand.php
│   │   │   │   │   ├── 🐘 TestSendMailCommand.php
│   │   │   │   │   ├── 🐘 ThemeCreateCommand.php
│   │   │   │   │   ├── 🐘 WidgetCreateCommand.php
│   │   │   │   │   └── 🐘 WidgetRemoveCommand.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   └── 🐘 DevToolServiceProvider.php
│   │   │   │   └── 🐘 Helper.php
│   │   │   ├── 📁 stubs
│   │   │   │   ├── 📁 child-theme
│   │   │   │   │   ├── 📁 assets
│   │   │   │   │   │   ├── 📁 js
│   │   │   │   │   │   │   └── 📄 script.js
│   │   │   │   │   │   └── 📁 sass
│   │   │   │   │   │       └── 🎨 style.scss
│   │   │   │   │   ├── 📁 functions
│   │   │   │   │   │   ├── 📄 functions.stub
│   │   │   │   │   │   ├── 📄 shortcodes.stub
│   │   │   │   │   │   └── 📄 theme-options.stub
│   │   │   │   │   ├── 📁 layouts
│   │   │   │   │   │   └── ⚙️ .gitkeep
│   │   │   │   │   ├── 📁 partials
│   │   │   │   │   │   └── ⚙️ .gitkeep
│   │   │   │   │   ├── 📁 public
│   │   │   │   │   │   └── ⚙️ .gitkeep
│   │   │   │   │   ├── 📁 src
│   │   │   │   │   │   └── ⚙️ .gitkeep
│   │   │   │   │   ├── 📁 views
│   │   │   │   │   │   └── ⚙️ .gitkeep
│   │   │   │   │   ├── 📄 config.stub
│   │   │   │   │   ├── ⚙️ theme.json
│   │   │   │   │   └── 📄 webpack.mix.js.stub
│   │   │   │   ├── 📁 module
│   │   │   │   │   ├── 📁 config
│   │   │   │   │   │   └── 📄 permissions.stub
│   │   │   │   │   ├── 📁 database
│   │   │   │   │   │   └── 📁 migrations
│   │   │   │   │   │       └── 📄 {migrate_date}_{module}_create_{name}_table.stub
│   │   │   │   │   ├── 📁 helpers
│   │   │   │   │   │   └── 📄 helpers.stub
│   │   │   │   │   ├── 📁 resources
│   │   │   │   │   │   └── 📁 views
│   │   │   │   │   │       └── ⚙️ .gitkeep
│   │   │   │   │   ├── 📁 routes
│   │   │   │   │   │   └── 📄 web.stub
│   │   │   │   │   ├── 📁 src
│   │   │   │   │   │   ├── 📁 Forms
│   │   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   │   └── 📄 {Name}Form.stub
│   │   │   │   │   │   │   └── 📄 {Name}Form.stub
│   │   │   │   │   │   ├── 📁 Http
│   │   │   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   │   │   └── 📄 {Name}Controller.stub
│   │   │   │   │   │   │   │   └── 📄 {Name}Controller.stub
│   │   │   │   │   │   │   └── 📁 Requests
│   │   │   │   │   │   │       ├── 📁 Settings
│   │   │   │   │   │   │       │   └── 📄 {Name}Request.stub
│   │   │   │   │   │   │       └── 📄 {Name}Request.stub
│   │   │   │   │   │   ├── 📁 Models
│   │   │   │   │   │   │   └── 📄 {Name}.stub
│   │   │   │   │   │   ├── 📁 PanelSections
│   │   │   │   │   │   │   └── 📄 {Name}PanelSection.stub
│   │   │   │   │   │   ├── 📁 Providers
│   │   │   │   │   │   │   └── 📄 {Name}ServiceProvider.stub
│   │   │   │   │   │   └── 📁 Tables
│   │   │   │   │   │       └── 📄 {Name}Table.stub
│   │   │   │   │   └── ⚙️ composer.json
│   │   │   │   ├── 📁 plugin
│   │   │   │   │   ├── 📁 src
│   │   │   │   │   │   └── 📁 Providers
│   │   │   │   │   │       └── 📄 {Name}ServiceProvider.stub
│   │   │   │   │   ├── 📄 Plugin.stub
│   │   │   │   │   └── ⚙️ plugin.json
│   │   │   │   ├── 📁 sub-module
│   │   │   │   │   ├── 📁 config
│   │   │   │   │   │   └── 📄 permissions.stub
│   │   │   │   │   ├── 📁 routes
│   │   │   │   │   │   ├── 📄 web-settings.stub
│   │   │   │   │   │   └── 📄 web.stub
│   │   │   │   │   └── 📁 src
│   │   │   │   │       ├── 📁 Providers
│   │   │   │   │       │   └── 📄 {Module}ServiceProvider.stub
│   │   │   │   │       └── 📄 Plugin.stub
│   │   │   │   ├── 📁 theme
│   │   │   │   │   ├── 📁 assets
│   │   │   │   │   │   ├── 📁 js
│   │   │   │   │   │   │   └── 📄 script.js
│   │   │   │   │   │   └── 📁 sass
│   │   │   │   │   │       └── 🎨 style.scss
│   │   │   │   │   ├── 📁 functions
│   │   │   │   │   │   ├── 📄 functions.stub
│   │   │   │   │   │   ├── 📄 shortcodes.stub
│   │   │   │   │   │   └── 📄 theme-options.stub
│   │   │   │   │   ├── 📁 layouts
│   │   │   │   │   │   └── 📄 default.blade.stub
│   │   │   │   │   ├── 📁 partials
│   │   │   │   │   │   ├── 📄 breadcrumbs.blade.stub
│   │   │   │   │   │   ├── 📄 footer.blade.stub
│   │   │   │   │   │   ├── 📄 header.blade.stub
│   │   │   │   │   │   ├── 📄 main-menu.blade.stub
│   │   │   │   │   │   └── 📄 recent-posts.blade.stub
│   │   │   │   │   ├── 📁 public
│   │   │   │   │   │   ├── 📁 css
│   │   │   │   │   │   │   └── 🎨 style.css
│   │   │   │   │   │   ├── 📁 js
│   │   │   │   │   │   │   └── 📄 script.js
│   │   │   │   │   │   └── 📁 libraries
│   │   │   │   │   ├── 📁 routes
│   │   │   │   │   │   └── 📄 web.stub
│   │   │   │   │   ├── 📁 src
│   │   │   │   │   │   └── 📁 Http
│   │   │   │   │   │       └── 📁 Controllers
│   │   │   │   │   │           └── 📄 {Theme}Controller.stub
│   │   │   │   │   ├── 📁 views
│   │   │   │   │   │   ├── 📄 404.blade.stub
│   │   │   │   │   │   ├── 📄 500.blade.stub
│   │   │   │   │   │   ├── 📄 503.blade.stub
│   │   │   │   │   │   ├── 📄 index.blade.stub
│   │   │   │   │   │   └── 📄 page.blade.stub
│   │   │   │   │   ├── 📄 README.md.stub
│   │   │   │   │   ├── 📄 config.stub
│   │   │   │   │   ├── ⚙️ theme.json
│   │   │   │   │   └── 📄 webpack.mix.js.stub
│   │   │   │   └── 📁 widget
│   │   │   │       ├── 📁 templates
│   │   │   │       │   ├── 📄 backend.blade.stub
│   │   │   │       │   └── 📄 frontend.blade.stub
│   │   │   │       ├── 📄 registration.stub
│   │   │   │       └── 📄 {widget}.stub
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ composer.json
│   │   ├── 📁 form-builder
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 config.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 button.php
│   │   │   │       ├── 🐘 buttongroup.php
│   │   │   │       ├── 🐘 checkbox.php
│   │   │   │       ├── 🐘 child_form.php
│   │   │   │       ├── 🐘 choice.php
│   │   │   │       ├── 🐘 collection.php
│   │   │   │       ├── 🐘 errors.php
│   │   │   │       ├── 🐘 form.php
│   │   │   │       ├── 🐘 help_block.php
│   │   │   │       ├── 🐘 label.php
│   │   │   │       ├── 🐘 radio.php
│   │   │   │       ├── 🐘 repeated.php
│   │   │   │       ├── 🐘 select.php
│   │   │   │       ├── 🐘 static.php
│   │   │   │       ├── 🐘 text.php
│   │   │   │       └── 🐘 textarea.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 AfterCollectingFieldRules.php
│   │   │   │   │   ├── 🐘 AfterFieldCreation.php
│   │   │   │   │   ├── 🐘 AfterFormCreation.php
│   │   │   │   │   ├── 🐘 AfterFormValidation.php
│   │   │   │   │   ├── 🐘 BeforeFormValidation.php
│   │   │   │   │   ├── 🐘 FormComponentRegistered.php
│   │   │   │   │   └── 🐘 FormComponentRegistering.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 FormBuilder.php
│   │   │   │   ├── 📁 Fields
│   │   │   │   │   ├── 🐘 ButtonGroupType.php
│   │   │   │   │   ├── 🐘 ButtonType.php
│   │   │   │   │   ├── 🐘 CheckableType.php
│   │   │   │   │   ├── 🐘 ChildFormType.php
│   │   │   │   │   ├── 🐘 ChoiceType.php
│   │   │   │   │   ├── 🐘 CollectionType.php
│   │   │   │   │   ├── 🐘 EntityType.php
│   │   │   │   │   ├── 🐘 FormField.php
│   │   │   │   │   ├── 🐘 InputType.php
│   │   │   │   │   ├── 🐘 ParentType.php
│   │   │   │   │   ├── 🐘 RepeatedType.php
│   │   │   │   │   ├── 🐘 SelectType.php
│   │   │   │   │   ├── 🐘 StaticType.php
│   │   │   │   │   └── 🐘 TextareaType.php
│   │   │   │   ├── 📁 Filters
│   │   │   │   │   ├── 📁 Collection
│   │   │   │   │   │   ├── 🐘 BaseName.php
│   │   │   │   │   │   ├── 🐘 HtmlEntities.php
│   │   │   │   │   │   ├── 🐘 Integer.php
│   │   │   │   │   │   ├── 🐘 Lowercase.php
│   │   │   │   │   │   ├── 🐘 PregReplace.php
│   │   │   │   │   │   ├── 🐘 StripNewlines.php
│   │   │   │   │   │   ├── 🐘 StripTags.php
│   │   │   │   │   │   ├── 🐘 Trim.php
│   │   │   │   │   │   ├── 🐘 Uppercase.php
│   │   │   │   │   │   └── 🐘 XSS.php
│   │   │   │   │   ├── 📁 Exception
│   │   │   │   │   │   ├── 🐘 FilterAlreadyBindedException.php
│   │   │   │   │   │   ├── 🐘 InvalidInstanceException.php
│   │   │   │   │   │   └── 🐘 UnableToResolveFilterException.php
│   │   │   │   │   ├── 🐘 FilterInterface.php
│   │   │   │   │   └── 🐘 FilterResolver.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   ├── 🐘 FormBuilder.php
│   │   │   │   │   └── 🐘 HtmlBuilder.php
│   │   │   │   ├── 📁 Traits
│   │   │   │   │   ├── 🐘 Componentable.php
│   │   │   │   │   └── 🐘 ValidatesWhenResolved.php
│   │   │   │   ├── 🐘 Field.php
│   │   │   │   ├── 🐘 Form.php
│   │   │   │   ├── 🐘 FormBuilder.php
│   │   │   │   ├── 🐘 FormBuilderServiceProvider.php
│   │   │   │   ├── 🐘 FormBuilderTrait.php
│   │   │   │   ├── 🐘 FormHelper.php
│   │   │   │   ├── 🐘 Rules.php
│   │   │   │   └── 🐘 RulesParser.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ composer.json
│   │   ├── 📁 get-started
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 get-started.css
│   │   │   │   ├── 📁 images
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 get-started.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 get-started.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 get-started.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 index.blade.php
│   │   │   │       └── 🐘 setup-wizard-notice.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 GetStartedController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 GetStartedRequest.php
│   │   │   │   └── 📁 Providers
│   │   │   │       └── 🐘 GetStartedServiceProvider.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 git-commit-checker
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 git-commit-checker.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 summary.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 InstallCommand.php
│   │   │   │   │   └── 🐘 PreCommitHookCommand.php
│   │   │   │   └── 📁 Providers
│   │   │   │       ├── 🐘 CommandServiceProvider.php
│   │   │   │       └── 🐘 GitCommitCheckerServiceProvider.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ composer.json
│   │   ├── 📁 installer
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 installer.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 css
│   │   │   │       └── 🎨 style.css
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 style.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 layouts
│   │   │   │       │   └── 🐘 master.blade.php
│   │   │   │       ├── 📁 partials
│   │   │   │       │   └── 🐘 alert.blade.php
│   │   │   │       ├── 🐘 account.blade.php
│   │   │   │       ├── 🐘 environment.blade.php
│   │   │   │       ├── 🐘 final.blade.php
│   │   │   │       ├── 🐘 license.blade.php
│   │   │   │       ├── 🐘 requirements.blade.php
│   │   │   │       ├── 🐘 theme-preset.blade.php
│   │   │   │       ├── 🐘 theme.blade.php
│   │   │   │       └── 🐘 welcome.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 DatabaseConnectionsEnum.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 EnvironmentSaved.php
│   │   │   │   │   └── 🐘 InstallerFinished.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   │   └── 🐘 InteractsWithDatabaseFile.php
│   │   │   │   │   │   ├── 🐘 AccountController.php
│   │   │   │   │   │   ├── 🐘 EnvironmentController.php
│   │   │   │   │   │   ├── 🐘 FinalController.php
│   │   │   │   │   │   ├── 🐘 InstallController.php
│   │   │   │   │   │   ├── 🐘 LicenseController.php
│   │   │   │   │   │   ├── 🐘 RequirementController.php
│   │   │   │   │   │   ├── 🐘 ThemeController.php
│   │   │   │   │   │   └── 🐘 ThemePresetController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   ├── 🐘 CheckIfInstalledMiddleware.php
│   │   │   │   │   │   ├── 🐘 CheckIfInstallingMiddleware.php
│   │   │   │   │   │   ├── 🐘 InstallerMiddleware.php
│   │   │   │   │   │   └── 🐘 RedirectIfNotInstalledMiddleware.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 ChooseThemePresetRequest.php
│   │   │   │   │       ├── 🐘 ChooseThemeRequest.php
│   │   │   │   │       ├── 🐘 SaveAccountRequest.php
│   │   │   │   │       └── 🐘 SaveEnvironmentRequest.php
│   │   │   │   ├── 📁 InstallerStep
│   │   │   │   │   ├── 🐘 InstallerStep.php
│   │   │   │   │   └── 🐘 InstallerStepItem.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 InstallerServiceProvider.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   ├── 🐘 CleanupSystemAfterInstalledService.php
│   │   │   │   │   └── 🐘 ImportDatabaseService.php
│   │   │   │   └── 📁 Supports
│   │   │   │       ├── 🐘 EnvironmentManager.php
│   │   │   │       └── 🐘 RequirementsChecker.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 menu
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2016_06_14_230857_create_menus_table.php
│   │   │   │       ├── 🐘 2022_04_20_101046_add_index_to_menu_table.php
│   │   │   │       └── 🐘 2024_07_07_091316_fix_column_url_in_menu_nodes_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 menu.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 menu.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 menu.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 menu.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 default.blade.php
│   │   │   │       │   ├── 🐘 menu.blade.php
│   │   │   │       │   ├── 🐘 node.blade.php
│   │   │   │       │   └── 🐘 select.blade.php
│   │   │   │       ├── 🐘 menu-options.blade.php
│   │   │   │       └── 🐘 menu-structure.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   └── 🐘 ClearMenuCacheCommand.php
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Traits
│   │   │   │   │       └── 🐘 HasMenuSeeder.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 RenderingMenuOptions.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 Menu.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 🐘 MenuForm.php
│   │   │   │   │   └── 🐘 MenuNodeForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 MenuController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 MenuNodeRequest.php
│   │   │   │   │       └── 🐘 MenuRequest.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 DeleteMenuNodeListener.php
│   │   │   │   │   └── 🐘 UpdateMenuNodeUrlListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 Menu.php
│   │   │   │   │   ├── 🐘 MenuLocation.php
│   │   │   │   │   └── 🐘 MenuNode.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   └── 🐘 MenuServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 MenuCacheDecorator.php
│   │   │   │   │   │   ├── 🐘 MenuLocationCacheDecorator.php
│   │   │   │   │   │   └── 🐘 MenuNodeCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 MenuLocationRepository.php
│   │   │   │   │   │   ├── 🐘 MenuNodeRepository.php
│   │   │   │   │   │   └── 🐘 MenuRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 MenuInterface.php
│   │   │   │   │       ├── 🐘 MenuLocationInterface.php
│   │   │   │   │       └── 🐘 MenuNodeInterface.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 MenuTable.php
│   │   │   │   ├── 📁 Widgets
│   │   │   │   │   └── 📁 Fronts
│   │   │   │   │       └── 🐘 CustomMenu.php
│   │   │   │   └── 🐘 Menu.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 optimize
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 📁 partials
│   │   │   │           └── 📁 settings
│   │   │   │               └── 📁 forms
│   │   │   │                   └── 🐘 optimize-fields.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 OptimizerHelper.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 📁 Settings
│   │   │   │   │       └── 🐘 OptimizeSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 📁 Settings
│   │   │   │   │   │       └── 🐘 OptimizeSettingController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   ├── 🐘 CollapseWhitespace.php
│   │   │   │   │   │   ├── 🐘 DeferJavascript.php
│   │   │   │   │   │   ├── 🐘 ElideAttributes.php
│   │   │   │   │   │   ├── 🐘 InlineCss.php
│   │   │   │   │   │   ├── 🐘 InsertDNSPrefetch.php
│   │   │   │   │   │   ├── 🐘 PageSpeed.php
│   │   │   │   │   │   ├── 🐘 RemoveComments.php
│   │   │   │   │   │   └── 🐘 RemoveQuotes.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 OptimizeSettingRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 OptimizeServiceProvider.php
│   │   │   │   └── 📁 Supports
│   │   │   │       └── 🐘 Optimizer.php
│   │   │   └── ⚙️ composer.json
│   │   ├── 📁 page
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2016_06_28_221418_create_pages_table.php
│   │   │   │       ├── 🐘 2022_10_14_024629_drop_column_is_featured.php
│   │   │   │       └── 🐘 2023_08_21_090810_make_page_content_nullable.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 📁 themes
│   │   │   │           └── 🐘 page.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   ├── 🐘 api.php
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Traits
│   │   │   │   │       └── 🐘 HasPageSeeder.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 PageForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 API
│   │   │   │   │   │   │   └── 🐘 PageController.php
│   │   │   │   │   │   ├── 🐘 PageController.php
│   │   │   │   │   │   └── 🐘 PublicController.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   └── 🐘 PageRequest.php
│   │   │   │   │   └── 📁 Resources
│   │   │   │   │       ├── 🐘 ListPageResource.php
│   │   │   │   │       └── 🐘 PageResource.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 RenderingSiteMapListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 Page.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 PageServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 PageCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 PageRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 PageInterface.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 PageService.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   └── 🐘 Template.php
│   │   │   │   └── 📁 Tables
│   │   │   │       └── 🐘 PageTable.php
│   │   │   └── ⚙️ composer.json
│   │   ├── 📁 plugin-generator
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 PluginCreateCommand.php
│   │   │   │   │   └── 🐘 PluginMakeCrudCommand.php
│   │   │   │   └── 📁 Providers
│   │   │   │       ├── 🐘 CommandServiceProvider.php
│   │   │   │       └── 🐘 PluginGeneratorServiceProvider.php
│   │   │   ├── 📁 stubs
│   │   │   │   ├── 📄 Plugin.stub
│   │   │   │   └── ⚙️ plugin.json
│   │   │   └── ⚙️ composer.json
│   │   ├── 📁 plugin-management
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 common.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 marketplace.js
│   │   │   │       └── 📄 plugin.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📁 components
│   │   │   │   │   │   ├── 📄 Pagination.vue
│   │   │   │   │   │   ├── 📄 PluginDetails.vue
│   │   │   │   │   │   ├── 📄 PluginItem.vue
│   │   │   │   │   │   ├── 📄 PluginList.vue
│   │   │   │   │   │   └── 📄 PluginPlaceholder.vue
│   │   │   │   │   ├── 📄 marketplace.js
│   │   │   │   │   └── 📄 plugin.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 index.blade.php
│   │   │   │       └── 🐘 marketplace.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Abstracts
│   │   │   │   │   └── 🐘 PluginOperationAbstract.php
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 📁 Concern
│   │   │   │   │   │   └── 🐘 HasPluginNameValidation.php
│   │   │   │   │   ├── 🐘 ClearCompiledCommand.php
│   │   │   │   │   ├── 🐘 IlluminateClearCompiledCommand.php
│   │   │   │   │   ├── 🐘 PackageDiscoverCommand.php
│   │   │   │   │   ├── 🐘 PluginActivateAllCommand.php
│   │   │   │   │   ├── 🐘 PluginActivateCommand.php
│   │   │   │   │   ├── 🐘 PluginAssetsPublishCommand.php
│   │   │   │   │   ├── 🐘 PluginDeactivateAllCommand.php
│   │   │   │   │   ├── 🐘 PluginDeactivateCommand.php
│   │   │   │   │   ├── 🐘 PluginDiscoverCommand.php
│   │   │   │   │   ├── 🐘 PluginInstallFromMarketplaceCommand.php
│   │   │   │   │   ├── 🐘 PluginListCommand.php
│   │   │   │   │   ├── 🐘 PluginRemoveAllCommand.php
│   │   │   │   │   ├── 🐘 PluginRemoveCommand.php
│   │   │   │   │   └── 🐘 PluginUpdateVersionInfoCommand.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 PluginFilterStatus.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 ActivatedPluginEvent.php
│   │   │   │   │   ├── 🐘 DeactivatedPlugin.php
│   │   │   │   │   ├── 🐘 RemovedPlugin.php
│   │   │   │   │   ├── 🐘 RenderingPluginListingPage.php
│   │   │   │   │   ├── 🐘 UpdatedPluginEvent.php
│   │   │   │   │   └── 🐘 UpdatingPluginEvent.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   └── 📁 Controllers
│   │   │   │   │       ├── 🐘 MarketplaceController.php
│   │   │   │   │       └── 🐘 PluginManagementController.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 ActivateAllPlugins.php
│   │   │   │   │   ├── 🐘 ClearPluginCaches.php
│   │   │   │   │   ├── 🐘 CoreUpdatePluginsDB.php
│   │   │   │   │   └── 🐘 PublishPluginAssets.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 PluginManagementServiceProvider.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   ├── 🐘 MarketplaceService.php
│   │   │   │   │   └── 🐘 PluginService.php
│   │   │   │   └── 🐘 PluginManifest.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 revision
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 general.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2013_04_09_062329_create_revisions_table.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 revision.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 html-diff.js
│   │   │   │       └── 📄 revision.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 revision.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 revision.scss
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 history-content.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 RevisionServiceProvider.php
│   │   │   │   ├── 🐘 FieldFormatter.php
│   │   │   │   ├── 🐘 Revision.php
│   │   │   │   └── 🐘 RevisionableTrait.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 seo-helper
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 general.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 seo-helper.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 seo-helper.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 seo-helper.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 seo-helper.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 homepage-meta-box.blade.php
│   │   │   │       └── 🐘 meta-box.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Bases
│   │   │   │   │   └── 🐘 MetaCollection.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   ├── 📁 Entities
│   │   │   │   │   │   ├── 🐘 AnalyticsContract.php
│   │   │   │   │   │   ├── 🐘 DescriptionContract.php
│   │   │   │   │   │   ├── 🐘 MetaCollectionContract.php
│   │   │   │   │   │   ├── 🐘 MiscTagsContract.php
│   │   │   │   │   │   ├── 🐘 OpenGraphContract.php
│   │   │   │   │   │   ├── 🐘 TitleContract.php
│   │   │   │   │   │   ├── 🐘 TwitterCardContract.php
│   │   │   │   │   │   └── 🐘 WebmastersContract.php
│   │   │   │   │   ├── 📁 Helpers
│   │   │   │   │   │   └── 🐘 MetaContract.php
│   │   │   │   │   ├── 🐘 RenderableContract.php
│   │   │   │   │   ├── 🐘 SeoHelperContract.php
│   │   │   │   │   ├── 🐘 SeoMetaContract.php
│   │   │   │   │   ├── 🐘 SeoOpenGraphContract.php
│   │   │   │   │   └── 🐘 SeoTwitterContract.php
│   │   │   │   ├── 📁 Entities
│   │   │   │   │   ├── 📁 OpenGraph
│   │   │   │   │   │   ├── 🐘 Graph.php
│   │   │   │   │   │   └── 🐘 MetaCollection.php
│   │   │   │   │   ├── 📁 Twitter
│   │   │   │   │   │   ├── 🐘 Card.php
│   │   │   │   │   │   └── 🐘 MetaCollection.php
│   │   │   │   │   ├── 🐘 Analytics.php
│   │   │   │   │   ├── 🐘 Description.php
│   │   │   │   │   ├── 🐘 MetaCollection.php
│   │   │   │   │   ├── 🐘 MiscTags.php
│   │   │   │   │   ├── 🐘 Title.php
│   │   │   │   │   └── 🐘 Webmasters.php
│   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   ├── 🐘 InvalidArgumentException.php
│   │   │   │   │   ├── 🐘 InvalidTwitterCardException.php
│   │   │   │   │   └── 🐘 SeoHelperException.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 SeoHelper.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 SeoForm.php
│   │   │   │   ├── 📁 Helpers
│   │   │   │   │   └── 🐘 Meta.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 CreatedContentListener.php
│   │   │   │   │   ├── 🐘 DeletedContentListener.php
│   │   │   │   │   └── 🐘 UpdatedContentListener.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 SeoHelperServiceProvider.php
│   │   │   │   ├── 🐘 SeoHelper.php
│   │   │   │   ├── 🐘 SeoMeta.php
│   │   │   │   ├── 🐘 SeoOpenGraph.php
│   │   │   │   └── 🐘 SeoTwitter.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 shortcode
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 shortcode.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constans.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 shortcode.css
│   │   │   │   ├── 📁 images
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 front-shortcode.js
│   │   │   │       ├── 📄 shortcode-fields.js
│   │   │   │       └── 📄 shortcode.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 shortcode-fields.js
│   │   │   │   │   └── 📄 shortcode.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 shortcode.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 fields
│   │   │   │       │   ├── 🐘 lazy-loading.blade.php
│   │   │   │       │   ├── 🐘 select.blade.php
│   │   │   │       │   └── 🐘 tabs.blade.php
│   │   │   │       ├── 📁 forms
│   │   │   │       │   └── 📁 fields
│   │   │   │       │       ├── 🐘 tabs.blade.php
│   │   │   │       │       └── 🐘 tags.blade.php
│   │   │   │       └── 📁 partials
│   │   │   │           ├── 🐘 lazy-loading-placeholder.blade.php
│   │   │   │           ├── 🐘 lazy-loading-script.blade.php
│   │   │   │           ├── 🐘 shortcode-button.blade.php
│   │   │   │           ├── 🐘 shortcode-cache-suggestion.blade.php
│   │   │   │           └── 🐘 shortcode-modal.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   ├── 🐘 fronts.php
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Compilers
│   │   │   │   │   ├── 🐘 Shortcode.php
│   │   │   │   │   └── 🐘 ShortcodeCompiler.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 ShortcodeAdminConfigRendering.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 Shortcode.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 FieldOptions
│   │   │   │   │   │   └── 🐘 ShortcodeTabsFieldOption.php
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   ├── 🐘 ShortcodeColorField.php
│   │   │   │   │   │   ├── 🐘 ShortcodeTabsField.php
│   │   │   │   │   │   └── 🐘 ShortcodeTagsField.php
│   │   │   │   │   └── 🐘 ShortcodeForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 ShortcodeController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   └── 🐘 ShortcodePerformanceMiddleware.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 GetShortcodeDataRequest.php
│   │   │   │   │       └── 🐘 RenderBlockUiRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 ShortcodeServiceProvider.php
│   │   │   │   ├── 📁 View
│   │   │   │   │   ├── 🐘 Factory.php
│   │   │   │   │   └── 🐘 View.php
│   │   │   │   ├── 🐘 Shortcode.php
│   │   │   │   └── 🐘 ShortcodeField.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 sitemap
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 config.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 styles
│   │   │   │       ├── 📄 google-news.xsl
│   │   │   │       ├── 📄 mobile.xsl
│   │   │   │       ├── 📄 sitemapindex.xsl
│   │   │   │       └── 📄 xml.xsl
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 indexnow-info.blade.php
│   │   │   │       │   └── 🐘 sitemap-info.blade.php
│   │   │   │       ├── 🐘 google-news.blade.php
│   │   │   │       ├── 🐘 html.blade.php
│   │   │   │       ├── 🐘 ror-rdf.blade.php
│   │   │   │       ├── 🐘 ror-rss.blade.php
│   │   │   │       ├── 🐘 sitemapindex.blade.php
│   │   │   │       ├── 🐘 txt.blade.php
│   │   │   │       ├── 🐘 xml-mobile.blade.php
│   │   │   │       └── 🐘 xml.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   └── 🐘 IndexNowSubmissionCommand.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 SitemapUpdatedEvent.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 📁 Settings
│   │   │   │   │       └── 🐘 SitemapSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 SitemapSettingController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 SitemapSettingRequest.php
│   │   │   │   ├── 📁 Jobs
│   │   │   │   │   └── 🐘 IndexNowSubmissionJob.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 IndexNowSubmissionListener.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 SitemapServiceProvider.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 IndexNowService.php
│   │   │   │   ├── 🐘 Model.php
│   │   │   │   └── 🐘 Sitemap.php
│   │   │   └── ⚙️ composer.json
│   │   ├── 📁 slug
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 general.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2017_11_03_070450_create_slug_table.php
│   │   │   │       ├── 🐘 2022_12_02_093615_update_slug_index_columns.php
│   │   │   │       ├── 🐘 2023_09_14_021936_update_index_for_slugs_table.php
│   │   │   │       └── 🐘 2025_07_31_add_performance_indexes_to_slugs_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 slug.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 front-slug.js
│   │   │   │       └── 📄 slug.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 front-slug.js
│   │   │   │   │   └── 📄 slug.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 slug.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 forms
│   │   │   │       │   └── 📁 fields
│   │   │   │       │       └── 🐘 permalink.blade.php
│   │   │   │       ├── 📁 partials
│   │   │   │       │   └── 🐘 slug.blade.php
│   │   │   │       └── 🐘 permalink.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   └── 🐘 ChangeSlugPrefixCommand.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 UpdatedPermalinkSettings.php
│   │   │   │   │   └── 🐘 UpdatedSlugEvent.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 SlugHelper.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   └── 🐘 PermalinkField.php
│   │   │   │   │   └── 🐘 SlugSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 SlugController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 SlugRequest.php
│   │   │   │   │       └── 🐘 SlugSettingsRequest.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 CreateMissingSlug.php
│   │   │   │   │   ├── 🐘 CreatedContentListener.php
│   │   │   │   │   ├── 🐘 DeletedContentListener.php
│   │   │   │   │   ├── 🐘 TruncateSlug.php
│   │   │   │   │   └── 🐘 UpdatedContentListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 Slug.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 FormServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 SlugServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 SlugCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 SlugRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 SlugInterface.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 SlugService.php
│   │   │   │   ├── 🐘 SlugCompiler.php
│   │   │   │   └── 🐘 SlugHelper.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 theme
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   ├── 🎨 admin-bar.css
│   │   │   │   │   ├── 🎨 guideline.css
│   │   │   │   │   └── 🎨 theme-options.css
│   │   │   │   ├── 📁 images
│   │   │   │   │   └── 📁 ui-blocks
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 icons-field.js
│   │   │   │   │   ├── 📄 theme-options.js
│   │   │   │   │   ├── 📄 theme.js
│   │   │   │   │   └── 📄 toast.js
│   │   │   │   └── 📁 plugins
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 icons-field.js
│   │   │   │   │   ├── 📄 theme-options.js
│   │   │   │   │   ├── 📄 theme.js
│   │   │   │   │   └── 📄 toast.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   ├── 🎨 admin-bar.scss
│   │   │   │   │   ├── 🎨 guideline.scss
│   │   │   │   │   └── 🎨 theme-options.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 errors
│   │   │   │       │   ├── 🐘 404.blade.php
│   │   │   │       │   ├── 🐘 500.blade.php
│   │   │   │       │   ├── 🐘 503.blade.php
│   │   │   │       │   └── 🐘 master.blade.php
│   │   │   │       ├── 📁 fields
│   │   │   │       │   └── 🐘 icons-field.blade.php
│   │   │   │       ├── 📁 forms
│   │   │   │       │   └── 📁 fields
│   │   │   │       │       ├── 📁 includes
│   │   │   │       │       │   └── 🐘 icon-fields-script.blade.php
│   │   │   │       │       └── 🐘 icons-field.blade.php
│   │   │   │       ├── 📁 fronts
│   │   │   │       │   ├── 🐘 preloader.blade.php
│   │   │   │       │   ├── 🐘 social-sharing.blade.php
│   │   │   │       │   └── 🐘 toast-notification.blade.php
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 📁 website-tracking
│   │   │   │       │   │   ├── 🐘 custom-setup-guide.blade.php
│   │   │   │       │   │   ├── 🐘 custom-verification-guide.blade.php
│   │   │   │       │   │   ├── 🐘 ga-setup-guide.blade.php
│   │   │   │       │   │   ├── 🐘 ga-verification-guide.blade.php
│   │   │   │       │   │   ├── 🐘 gtm-add-ga4-guide.blade.php
│   │   │   │       │   │   ├── 🐘 gtm-setup-guide.blade.php
│   │   │   │       │   │   └── 🐘 gtm-verification-guide.blade.php
│   │   │   │       │   ├── 🐘 breadcrumb.blade.php
│   │   │   │       │   ├── 🐘 facebook-comments.blade.php
│   │   │   │       │   ├── 🐘 facebook-integration.blade.php
│   │   │   │       │   ├── 🐘 footer.blade.php
│   │   │   │       │   ├── 🐘 header.blade.php
│   │   │   │       │   └── 🐘 no-meta-keywords.blade.php
│   │   │   │       ├── 📁 shortcodes
│   │   │   │       │   ├── 🐘 audio.blade.php
│   │   │   │       │   ├── 🐘 google-map.blade.php
│   │   │   │       │   ├── 🐘 media.blade.php
│   │   │   │       │   ├── 🐘 video.blade.php
│   │   │   │       │   └── 🐘 youtube.blade.php
│   │   │   │       ├── 🐘 admin-bar.blade.php
│   │   │   │       ├── 🐘 guideline-link.blade.php
│   │   │   │       ├── 🐘 list.blade.php
│   │   │   │       ├── 🐘 options.blade.php
│   │   │   │       └── 🐘 toast-notification.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   ├── 🐘 public.php
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 📁 Traits
│   │   │   │   │   │   └── 🐘 ThemeTrait.php
│   │   │   │   │   ├── 🐘 ThemeActivateCommand.php
│   │   │   │   │   ├── 🐘 ThemeAssetsPublishCommand.php
│   │   │   │   │   ├── 🐘 ThemeAssetsRemoveCommand.php
│   │   │   │   │   ├── 🐘 ThemeClearCacheCommand.php
│   │   │   │   │   ├── 🐘 ThemeOptionCheckMissingCommand.php
│   │   │   │   │   ├── 🐘 ThemeRemoveCommand.php
│   │   │   │   │   └── 🐘 ThemeRenameCommand.php
│   │   │   │   ├── 📁 Concerns
│   │   │   │   │   └── 📁 ThemeOption
│   │   │   │   │       └── 📁 Fields
│   │   │   │   │           └── 🐘 HasOptions.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   └── 🐘 Theme.php
│   │   │   │   ├── 📁 Database
│   │   │   │   │   ├── 📁 Seeders
│   │   │   │   │   │   └── 🐘 ThemeSeeder.php
│   │   │   │   │   └── 📁 Traits
│   │   │   │   │       └── 🐘 HasThemeOptionSeeder.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 RenderingAdminBar.php
│   │   │   │   │   ├── 🐘 RenderingHomePageEvent.php
│   │   │   │   │   ├── 🐘 RenderingSingleEvent.php
│   │   │   │   │   ├── 🐘 RenderingSiteMapEvent.php
│   │   │   │   │   ├── 🐘 RenderingThemeOptionSettings.php
│   │   │   │   │   ├── 🐘 ThemeRemoveEvent.php
│   │   │   │   │   ├── 🐘 ThemeRoutingAfterEvent.php
│   │   │   │   │   └── 🐘 ThemeRoutingBeforeEvent.php
│   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   ├── 🐘 UnknownLayoutFileException.php
│   │   │   │   │   ├── 🐘 UnknownPartialFileException.php
│   │   │   │   │   ├── 🐘 UnknownThemeException.php
│   │   │   │   │   └── 🐘 UnknownViewFileException.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   ├── 🐘 AdminBar.php
│   │   │   │   │   ├── 🐘 Manager.php
│   │   │   │   │   ├── 🐘 SiteMapManager.php
│   │   │   │   │   ├── 🐘 Theme.php
│   │   │   │   │   └── 🐘 ThemeOption.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   └── 🐘 ThemeIconField.php
│   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   └── 🐘 WebsiteTrackingSettingForm.php
│   │   │   │   │   ├── 🐘 CustomCSSForm.php
│   │   │   │   │   ├── 🐘 CustomHTMLForm.php
│   │   │   │   │   ├── 🐘 CustomJSForm.php
│   │   │   │   │   └── 🐘 RobotsTxtEditorForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 PublicController.php
│   │   │   │   │   │   ├── 🐘 ThemeController.php
│   │   │   │   │   │   └── 🐘 WebsiteTrackingSettingController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 CustomCssRequest.php
│   │   │   │   │       ├── 🐘 CustomHtmlRequest.php
│   │   │   │   │       ├── 🐘 CustomJsRequest.php
│   │   │   │   │       ├── 🐘 RobotsTxtRequest.php
│   │   │   │   │       ├── 🐘 UpdateOptionsRequest.php
│   │   │   │   │       └── 🐘 WebsiteTrackingSettingRequest.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 AddFormJsValidation.php
│   │   │   │   │   ├── 🐘 ClearThemeCache.php
│   │   │   │   │   ├── 🐘 CoreUpdateThemeDB.php
│   │   │   │   │   ├── 🐘 PublishThemeAssets.php
│   │   │   │   │   └── 🐘 SetDefaultTheme.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   ├── 🐘 RouteServiceProvider.php
│   │   │   │   │   ├── 🐘 ThemeManagementServiceProvider.php
│   │   │   │   │   └── 🐘 ThemeServiceProvider.php
│   │   │   │   ├── 📁 Rules
│   │   │   │   │   └── 🐘 GoogleTrackingIdRule.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 ThemeService.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   ├── 🐘 AdminBar.php
│   │   │   │   │   ├── 🐘 FormFrontHelper.php
│   │   │   │   │   ├── 🐘 GoogleTagManagerEnhanced.php
│   │   │   │   │   ├── 🐘 SiteMapManager.php
│   │   │   │   │   ├── 🐘 SocialLink.php
│   │   │   │   │   ├── 🐘 ThemeSupport.php
│   │   │   │   │   ├── 🐘 Vimeo.php
│   │   │   │   │   └── 🐘 Youtube.php
│   │   │   │   ├── 📁 ThemeOption
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   ├── 🐘 ColorField.php
│   │   │   │   │   │   ├── 🐘 GoogleFontsField.php
│   │   │   │   │   │   ├── 🐘 IconField.php
│   │   │   │   │   │   ├── 🐘 MediaImageField.php
│   │   │   │   │   │   ├── 🐘 MultiCheckListField.php
│   │   │   │   │   │   ├── 🐘 NumberField.php
│   │   │   │   │   │   ├── 🐘 RadioField.php
│   │   │   │   │   │   ├── 🐘 RepeaterField.php
│   │   │   │   │   │   ├── 🐘 SelectField.php
│   │   │   │   │   │   ├── 🐘 TextField.php
│   │   │   │   │   │   ├── 🐘 TextareaField.php
│   │   │   │   │   │   ├── 🐘 ToggleField.php
│   │   │   │   │   │   └── 🐘 UiSelectorField.php
│   │   │   │   │   ├── 🐘 ThemeOptionField.php
│   │   │   │   │   └── 🐘 ThemeOptionSection.php
│   │   │   │   ├── 📁 Typography
│   │   │   │   │   ├── 🐘 Typography.php
│   │   │   │   │   └── 🐘 TypographyItem.php
│   │   │   │   ├── 🐘 Asset.php
│   │   │   │   ├── 🐘 AssetContainer.php
│   │   │   │   ├── 🐘 Breadcrumb.php
│   │   │   │   ├── 🐘 FormFront.php
│   │   │   │   ├── 🐘 FormFrontManager.php
│   │   │   │   ├── 🐘 Manager.php
│   │   │   │   ├── 🐘 Theme.php
│   │   │   │   └── 🐘 ThemeOption.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 theme-generator
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 assets
│   │   │   │       └── 📁 images
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   └── 🐘 ThemeCreateCommand.php
│   │   │   │   └── 📁 Providers
│   │   │   │       ├── 🐘 CommandServiceProvider.php
│   │   │   │       └── 🐘 ThemeGeneratorServiceProvider.php
│   │   │   ├── 📁 stubs
│   │   │   │   ├── 📁 assets
│   │   │   │   │   ├── 📁 js
│   │   │   │   │   │   └── 📄 script.js
│   │   │   │   │   └── 📁 sass
│   │   │   │   │       └── 🎨 style.scss
│   │   │   │   ├── 📁 functions
│   │   │   │   │   ├── 📄 functions.stub
│   │   │   │   │   ├── 📄 shortcodes.stub
│   │   │   │   │   └── 📄 theme-options.stub
│   │   │   │   ├── 📁 layouts
│   │   │   │   │   └── 📄 default.blade.stub
│   │   │   │   ├── 📁 partials
│   │   │   │   │   ├── 📄 footer.blade.stub
│   │   │   │   │   └── 📄 header.blade.stub
│   │   │   │   ├── 📁 public
│   │   │   │   │   ├── 📁 css
│   │   │   │   │   │   └── 🎨 style.css
│   │   │   │   │   ├── 📁 js
│   │   │   │   │   │   └── 📄 script.js
│   │   │   │   │   └── 📁 libraries
│   │   │   │   ├── 📁 routes
│   │   │   │   │   └── 📄 web.stub
│   │   │   │   ├── 📁 src
│   │   │   │   │   └── 📁 Http
│   │   │   │   │       └── 📁 Controllers
│   │   │   │   │           └── 📄 {Theme}Controller.stub
│   │   │   │   ├── 📁 views
│   │   │   │   │   ├── 📄 404.blade.stub
│   │   │   │   │   ├── 📄 500.blade.stub
│   │   │   │   │   ├── 📄 503.blade.stub
│   │   │   │   │   ├── 📄 index.blade.stub
│   │   │   │   │   └── 📄 page.blade.stub
│   │   │   │   ├── 📄 config.stub
│   │   │   │   ├── ⚙️ theme.json
│   │   │   │   └── 📄 webpack.mix.js.stub
│   │   │   └── ⚙️ composer.json
│   │   ├── 📁 widget
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2016_12_16_084601_create_widgets_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 widget.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 widget.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 widget.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 widget.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   └── 🐘 widget-cache-suggestion.blade.php
│   │   │   │       ├── 📁 widgets
│   │   │   │       │   ├── 📁 core-simple-menu
│   │   │   │       │   │   ├── 🐘 backend.blade.php
│   │   │   │       │   │   └── 🐘 frontend.blade.php
│   │   │   │       │   └── 📁 text
│   │   │   │       │       ├── 🐘 backend.blade.php
│   │   │   │       │       └── 🐘 frontend.blade.php
│   │   │   │       ├── 🐘 item.blade.php
│   │   │   │       └── 🐘 list.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Traits
│   │   │   │   │       └── 🐘 HasWidgetSeeder.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 RenderingWidgetSettings.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   ├── 🐘 Widget.php
│   │   │   │   │   └── 🐘 WidgetGroup.php
│   │   │   │   ├── 📁 Factories
│   │   │   │   │   ├── 🐘 AbstractWidgetFactory.php
│   │   │   │   │   └── 🐘 WidgetFactory.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 WidgetForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 WidgetController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 WidgetRequest.php
│   │   │   │   ├── 📁 Misc
│   │   │   │   │   ├── 🐘 InvalidWidgetClassException.php
│   │   │   │   │   └── 🐘 ViewExpressionTrait.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 Widget.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 WidgetServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 WidgetCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 WidgetRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 WidgetInterface.php
│   │   │   │   ├── 📁 Widgets
│   │   │   │   │   ├── 📁 ValueObjects
│   │   │   │   │   │   └── 🐘 CoreSimpleMenuItem.php
│   │   │   │   │   ├── 🐘 CoreSimpleMenu.php
│   │   │   │   │   ├── 🐘 SiteCopyright.php
│   │   │   │   │   └── 🐘 Text.php
│   │   │   │   ├── 🐘 AbstractWidget.php
│   │   │   │   ├── 🐘 WidgetGroup.php
│   │   │   │   ├── 🐘 WidgetGroupCollection.php
│   │   │   │   └── 🐘 WidgetId.php
│   │   │   ├── ⚙️ composer.json
│   │   │   └── 📄 webpack.mix.js
│   │   └── 📁 widget-generator
│   │       ├── 📁 src
│   │       │   ├── 📁 Commands
│   │       │   │   ├── 🐘 WidgetCreateCommand.php
│   │       │   │   └── 🐘 WidgetRemoveCommand.php
│   │       │   └── 📁 Providers
│   │       │       ├── 🐘 CommandServiceProvider.php
│   │       │       └── 🐘 WidgetGeneratorServiceProvider.php
│   │       ├── 📁 stubs
│   │       │   ├── 📁 templates
│   │       │   │   ├── 📄 backend.blade.stub
│   │       │   │   └── 📄 frontend.blade.stub
│   │       │   ├── 📄 registration.stub
│   │       │   └── 📄 {widget}.stub
│   │       └── ⚙️ composer.json
│   ├── 📁 plugins
│   │   ├── 📁 2fa
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2023_05_08_103016_create_two_factor_authentications_table.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 images
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 2fa-vue3.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📁 components
│   │   │   │   │   │   ├── 📄 TwoFactorChallenge.vue
│   │   │   │   │   │   ├── 📄 TwoFactorRemoveModal.vue
│   │   │   │   │   │   └── 📄 TwoFactorSetupModal.vue
│   │   │   │   │   └── 📄 2fa.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 2fa.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 profile
│   │   │   │       │   └── 🐘 content.blade.php
│   │   │   │       └── 🐘 challenge.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Actions
│   │   │   │   │   ├── 🐘 ConfirmTwoFactorAuthentication.php
│   │   │   │   │   ├── 🐘 CreateTwoFactorRecord.php
│   │   │   │   │   ├── 🐘 DisableTwoFactorAuthentication.php
│   │   │   │   │   ├── 🐘 EnableTwoFactorAuthentication.php
│   │   │   │   │   ├── 🐘 GenerateTwoFactorQrCodeSvg.php
│   │   │   │   │   ├── 🐘 GenerateTwoFactorQrCodeUrl.php
│   │   │   │   │   └── 🐘 RedirectIfTwoFactorAuthenticatable.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   └── 🐘 TwoFactorAuthenticationProvider.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 📁 Settings
│   │   │   │   │       └── 🐘 TwoFactorAuthenticationSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 TwoFactorAuthenticationSettingController.php
│   │   │   │   │   │   ├── 🐘 ConfirmedTwoFactorAuthenticationController.php
│   │   │   │   │   │   ├── 🐘 RecoveryCodeController.php
│   │   │   │   │   │   ├── 🐘 TwoFactorAuthenticatedSessionController.php
│   │   │   │   │   │   ├── 🐘 TwoFactorAuthenticationController.php
│   │   │   │   │   │   └── 🐘 TwoFactorQrCodeController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Settings
│   │   │   │   │       │   └── 🐘 TwoFactorAuthenticationSettingRequest.php
│   │   │   │   │       └── 🐘 ConfirmTwoFactorCodeRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 TwoFactorAuthentication.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 TwoFactorAuthenticationServiceProvider.php
│   │   │   │   ├── 🐘 Plugin.php
│   │   │   │   ├── 🐘 RecoveryCode.php
│   │   │   │   ├── 🐘 TwoFactor.php
│   │   │   │   └── 🐘 TwoFactorAuthenticationProvider.php
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 analytics
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2024_04_27_100730_improve_analytics_setting.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 analytics.js
│   │   │   │   │   └── 📄 settings.js
│   │   │   │   └── 📁 libraries
│   │   │   │       └── 📁 jvectormap
│   │   │   │           ├── 🎨 jquery-jvectormap-1.2.2.css
│   │   │   │           └── 📄 jquery-jvectormap-world-mill-en.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 ga
│   │   │   │   │   ├── ⚙️ beta_analytics_data_client_config.json
│   │   │   │   │   ├── 🐘 beta_analytics_data_descriptor_config.php
│   │   │   │   │   └── 🐘 beta_analytics_data_rest_client_config.php
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 analytics.js
│   │   │   │   │   └── 📄 settings.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 widgets
│   │   │   │       │   ├── 🐘 browser.blade.php
│   │   │   │       │   ├── 🐘 empty-state.blade.php
│   │   │   │       │   ├── 🐘 general.blade.php
│   │   │   │       │   ├── 🐘 page.blade.php
│   │   │   │       │   └── 🐘 referrer.blade.php
│   │   │   │       ├── 🐘 missing-library-warning.blade.php
│   │   │   │       └── 🐘 upload-button.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Abstracts
│   │   │   │   │   ├── 🐘 AnalyticsAbstract.php
│   │   │   │   │   └── 🐘 AnalyticsContract.php
│   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   ├── 🐘 InvalidConfiguration.php
│   │   │   │   │   └── 🐘 InvalidPeriod.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 Analytics.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 AnalyticsSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 AnalyticsSettingController.php
│   │   │   │   │   │   ├── 🐘 AnalyticsController.php
│   │   │   │   │   │   └── 🐘 AnalyticsSettingJsonController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Settings
│   │   │   │   │       │   └── 🐘 AnalyticsSettingRequest.php
│   │   │   │   │       └── 🐘 AnalyticsRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 AnalyticsServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Rules
│   │   │   │   │   └── 🐘 AnalyticsCredentialRule.php
│   │   │   │   ├── 📁 Traits
│   │   │   │   │   ├── 🐘 DateRangeTrait.php
│   │   │   │   │   ├── 🐘 DimensionTrait.php
│   │   │   │   │   ├── 🐘 FilterByDimensionTrait.php
│   │   │   │   │   ├── 🐘 FilterByMetricTrait.php
│   │   │   │   │   ├── 🐘 MetricAggregationTrait.php
│   │   │   │   │   ├── 🐘 MetricTrait.php
│   │   │   │   │   ├── 🐘 OrderByDimensionTrait.php
│   │   │   │   │   ├── 🐘 OrderByMetricTrait.php
│   │   │   │   │   ├── 🐘 ResponseTrait.php
│   │   │   │   │   └── 🐘 RowOperationTrait.php
│   │   │   │   ├── 🐘 Analytics.php
│   │   │   │   ├── 🐘 AnalyticsResponse.php
│   │   │   │   ├── 🐘 Period.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 audit-log
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2015_06_29_025744_create_audit_history.php
│   │   │   │       ├── 🐘 2023_11_14_033417_change_request_column_in_table_audit_histories.php
│   │   │   │       └── 🐘 2025_05_05_000001_add_user_type_to_audit_histories_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 audit-log.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 audit-log.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 widgets
│   │   │   │       │   └── 🐘 activities.blade.php
│   │   │   │       ├── 🐘 activity-line.blade.php
│   │   │   │       └── 🐘 table.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 ActivityLogClearCommand.php
│   │   │   │   │   └── 🐘 CleanOldLogsCommand.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 AuditHandlerEvent.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   └── 📁 Controllers
│   │   │   │   │       └── 🐘 AuditLogController.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 AuditHandlerListener.php
│   │   │   │   │   ├── 🐘 CreatedContentListener.php
│   │   │   │   │   ├── 🐘 CustomerLoginListener.php
│   │   │   │   │   ├── 🐘 CustomerLogoutListener.php
│   │   │   │   │   ├── 🐘 CustomerRegistrationListener.php
│   │   │   │   │   ├── 🐘 DeletedContentListener.php
│   │   │   │   │   └── 🐘 UpdatedContentListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 AuditHistory.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 AuditLogServiceProvider.php
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 AuditLogCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 AuditLogRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 AuditLogInterface.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 AuditLogTable.php
│   │   │   │   ├── 🐘 AuditLog.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 backup
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 backup.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 backup.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 backup.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 backup.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 admin-alert.blade.php
│   │   │   │       │   └── 🐘 backup-item.blade.php
│   │   │   │       └── 🐘 index.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 BackupCleanCommand.php
│   │   │   │   │   ├── 🐘 BackupCreateCommand.php
│   │   │   │   │   ├── 🐘 BackupListCommand.php
│   │   │   │   │   ├── 🐘 BackupRemoveCommand.php
│   │   │   │   │   └── 🐘 BackupRestoreCommand.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 BackupController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 BackupRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 BackupServiceProvider.php
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   ├── 📁 MySql
│   │   │   │   │   │   ├── 🐘 CompressManagerFactory.php
│   │   │   │   │   │   ├── 🐘 CompressNone.php
│   │   │   │   │   │   ├── 🐘 MySqlDump.php
│   │   │   │   │   │   ├── 🐘 TypeAdapter.php
│   │   │   │   │   │   ├── 🐘 TypeAdapterFactory.php
│   │   │   │   │   │   └── 🐘 TypeAdapterMysql.php
│   │   │   │   │   ├── 📁 PgSql
│   │   │   │   │   │   ├── 🐘 Backup.php
│   │   │   │   │   │   └── 🐘 Restore.php
│   │   │   │   │   └── 🐘 Backup.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 barcode-generator
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   ├── 📁 migrations
│   │   │   │   │   ├── 🐘 2024_12_0001_create_barcode_templates_table.php
│   │   │   │   │   ├── 🐘 2024_12_0002_seed_default_barcode_templates.php
│   │   │   │   │   └── 🐘 2024_12_0003_add_smart_pricing_templates.php
│   │   │   │   └── 📁 seeders
│   │   │   │       └── 🐘 BarcodeTemplateSeeder.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 barcode-generator.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 barcode-generator.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 barcode-generator.js
│   │   │   │   │   └── 📄 setup-wizard.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 barcode-generator.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 field-display-info.blade.php
│   │   │   │       │   ├── 🐘 help-info.blade.php
│   │   │   │       │   └── 🐘 reset-settings.blade.php
│   │   │   │       ├── 📁 setup-wizard
│   │   │   │       │   └── 🐘 index.blade.php
│   │   │   │       ├── 📁 templates
│   │   │   │       │   ├── 🐘 create.blade.php
│   │   │   │       │   ├── 🐘 edit.blade.php
│   │   │   │       │   └── 🐘 index.blade.php
│   │   │   │       └── 🐘 generate.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   ├── 🐘 BarcodeTypeEnum.php
│   │   │   │   │   └── 🐘 PaperSizeEnum.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   └── 🐘 BarcodeGeneratorSettingForm.php
│   │   │   │   │   └── 🐘 BarcodeTemplateForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 BarcodeGeneratorSettingController.php
│   │   │   │   │   │   ├── 🐘 BarcodeGeneratorController.php
│   │   │   │   │   │   ├── 🐘 BarcodeTemplateController.php
│   │   │   │   │   │   ├── 🐘 SetupWizardController.php
│   │   │   │   │   │   └── 🐘 TestBarcodeController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Settings
│   │   │   │   │       │   └── 🐘 BarcodeGeneratorSettingRequest.php
│   │   │   │   │       └── 🐘 BarcodeTemplateRequest.php
│   │   │   │   ├── 📁 Libraries
│   │   │   │   │   └── 🐘 BarcodeGenerator.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 BarcodeTemplate.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 BarcodeGeneratorServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 BarcodeGeneratorService.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 BarcodeTemplateTable.php
│   │   │   │   ├── 🐘 Plugin.php
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 block
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2017_02_13_034601_create_blocks_table.php
│   │   │   │       ├── 🐘 2021_12_03_081327_create_blocks_translations.php
│   │   │   │       └── 🐘 2024_09_05_071942_add_raw_content_to_blocks_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 resources
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Seeders
│   │   │   │   │       └── 🐘 StaticBlockSeeder.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 BlockForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 BlockController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 BlockRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 Block.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 BlockServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 BlockCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 BlockRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 BlockInterface.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 BlockTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 blog
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2015_06_18_033822_create_blog_table.php
│   │   │   │       ├── 🐘 2021_02_16_092633_remove_default_value_for_author_type.php
│   │   │   │       ├── 🐘 2021_12_03_030600_create_blog_translations.php
│   │   │   │       ├── 🐘 2022_04_19_113923_add_index_to_table_posts.php
│   │   │   │       ├── 🐘 2023_08_29_074620_make_column_author_id_nullable.php
│   │   │   │       ├── 🐘 2024_07_30_091615_fix_order_column_in_categories_table.php
│   │   │   │       └── 🐘 2025_01_06_033807_add_default_value_for_categories_author_type.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 blog.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 blog.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 categories
│   │   │   │       │   ├── 🐘 actions.blade.php
│   │   │   │       │   ├── 🐘 form-tree-category.blade.php
│   │   │   │       │   └── 🐘 intro.blade.php
│   │   │   │       ├── 📁 posts
│   │   │   │       │   └── 🐘 export.blade.php
│   │   │   │       ├── 📁 themes
│   │   │   │       │   ├── 📁 templates
│   │   │   │       │   │   └── 🐘 posts.blade.php
│   │   │   │       │   ├── 🐘 category.blade.php
│   │   │   │       │   ├── 🐘 loop.blade.php
│   │   │   │       │   ├── 🐘 post.blade.php
│   │   │   │       │   └── 🐘 tag.blade.php
│   │   │   │       └── 📁 widgets
│   │   │   │           └── 🐘 posts.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   ├── 🐘 api.php
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Traits
│   │   │   │   │       └── 🐘 HasBlogSeeder.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 PostStatusEnum.php
│   │   │   │   ├── 📁 Exporters
│   │   │   │   │   └── 🐘 PostExporter.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   └── 🐘 CategoryMultiField.php
│   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   └── 🐘 BlogSettingForm.php
│   │   │   │   │   ├── 🐘 CategoryForm.php
│   │   │   │   │   ├── 🐘 PostForm.php
│   │   │   │   │   └── 🐘 TagForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 API
│   │   │   │   │   │   │   ├── 🐘 CategoryController.php
│   │   │   │   │   │   │   ├── 🐘 PostController.php
│   │   │   │   │   │   │   └── 🐘 TagController.php
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 BlogSettingController.php
│   │   │   │   │   │   ├── 🐘 CategoryController.php
│   │   │   │   │   │   ├── 🐘 ExportPostController.php
│   │   │   │   │   │   ├── 🐘 ImportPostController.php
│   │   │   │   │   │   ├── 🐘 PostController.php
│   │   │   │   │   │   ├── 🐘 PublicController.php
│   │   │   │   │   │   └── 🐘 TagController.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 BlogSettingRequest.php
│   │   │   │   │   │   ├── 🐘 CategoryRequest.php
│   │   │   │   │   │   ├── 🐘 PostRequest.php
│   │   │   │   │   │   └── 🐘 TagRequest.php
│   │   │   │   │   └── 📁 Resources
│   │   │   │   │       ├── 🐘 CategoryResource.php
│   │   │   │   │       ├── 🐘 ListCategoryResource.php
│   │   │   │   │       ├── 🐘 ListPostResource.php
│   │   │   │   │       ├── 🐘 PostResource.php
│   │   │   │   │       └── 🐘 TagResource.php
│   │   │   │   ├── 📁 Importers
│   │   │   │   │   └── 🐘 PostImporter.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 RenderingSiteMapListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 Category.php
│   │   │   │   │   ├── 🐘 Post.php
│   │   │   │   │   └── 🐘 Tag.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 BlogServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 CategoryCacheDecorator.php
│   │   │   │   │   │   ├── 🐘 PostCacheDecorator.php
│   │   │   │   │   │   └── 🐘 TagCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 CategoryRepository.php
│   │   │   │   │   │   ├── 🐘 PostRepository.php
│   │   │   │   │   │   └── 🐘 TagRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 CategoryInterface.php
│   │   │   │   │       ├── 🐘 PostInterface.php
│   │   │   │   │       └── 🐘 TagInterface.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   ├── 📁 Abstracts
│   │   │   │   │   │   ├── 🐘 StoreCategoryServiceAbstract.php
│   │   │   │   │   │   └── 🐘 StoreTagServiceAbstract.php
│   │   │   │   │   ├── 🐘 BlogService.php
│   │   │   │   │   ├── 🐘 StoreCategoryService.php
│   │   │   │   │   └── 🐘 StoreTagService.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   ├── 🐘 FilterCategory.php
│   │   │   │   │   ├── 🐘 FilterPost.php
│   │   │   │   │   └── 🐘 PostFormat.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   ├── 🐘 CategoryTable.php
│   │   │   │   │   ├── 🐘 PostTable.php
│   │   │   │   │   └── 🐘 TagTable.php
│   │   │   │   ├── 📁 Widgets
│   │   │   │   │   └── 📁 Fronts
│   │   │   │   │       ├── 🐘 Categories.php
│   │   │   │   │       ├── 🐘 Posts.php
│   │   │   │   │       ├── 🐘 RecentPosts.php
│   │   │   │   │       └── 🐘 Tags.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 captcha
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 forms
│   │   │   │       │   ├── 📁 fields
│   │   │   │       │   │   ├── 🐘 math-captcha.blade.php
│   │   │   │       │   │   └── 🐘 recaptcha.blade.php
│   │   │   │       │   └── 🐘 old-version-support.blade.php
│   │   │   │       ├── 📁 v2
│   │   │   │       │   ├── 🐘 html.blade.php
│   │   │   │       │   └── 🐘 script.blade.php
│   │   │   │       ├── 📁 v3
│   │   │   │       │   ├── 🐘 head.blade.php
│   │   │   │       │   ├── 🐘 html.blade.php
│   │   │   │       │   └── 🐘 script.blade.php
│   │   │   │       └── 🐘 header-meta.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   └── 🐘 Captcha.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 CaptchaRendered.php
│   │   │   │   │   └── 🐘 CaptchaRendering.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 Captcha.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   ├── 🐘 MathCaptchaField.php
│   │   │   │   │   │   └── 🐘 ReCaptchaField.php
│   │   │   │   │   └── 🐘 CaptchaSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 📁 Settings
│   │   │   │   │   │       └── 🐘 CaptchaSettingController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 📁 Settings
│   │   │   │   │           └── 🐘 CaptchaSettingRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 CaptchaServiceProvider.php
│   │   │   │   ├── 🐘 Captcha.php
│   │   │   │   ├── 🐘 CaptchaV3.php
│   │   │   │   ├── 🐘 MathCaptcha.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 code-highlighter
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 libraries
│   │   │   │       └── 📁 hljs
│   │   │   │           ├── 📁 styles
│   │   │   │           │   └── 📁 base16
│   │   │   │           └── 📄 LICENSE
│   │   │   ├── 📁 resources
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 CodeHighlighterSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 SettingController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 CodeHighlighterSettingRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 CodeHighlighterServiceProvider.php
│   │   │   │   ├── 🐘 CodeHighlighter.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 comment
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2024_01_16_050056_create_comments_table.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 comment.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 comment.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 comment.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 comment.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 list.blade.php
│   │   │   │       │   └── 🐘 permalink.blade.php
│   │   │   │       ├── 📁 tables
│   │   │   │       │   ├── 🐘 author-column.blade.php
│   │   │   │       │   ├── 🐘 content-column.blade.php
│   │   │   │       │   ├── 🐘 reply-button.blade.php
│   │   │   │       │   └── 🐘 table.blade.php
│   │   │   │       └── 🐘 comment.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Actions
│   │   │   │   │   ├── 🐘 CreateNewComment.php
│   │   │   │   │   └── 🐘 GetCommentReference.php
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Seeders
│   │   │   │   │       └── 🐘 CommentSeeder.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 CommentStatus.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   └── 🐘 CommentForm.php
│   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   └── 🐘 CommentSettingForm.php
│   │   │   │   │   ├── 🐘 CommentForm.php
│   │   │   │   │   └── 🐘 ReplyCommentForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   │   ├── 🐘 CommentController.php
│   │   │   │   │   │   │   └── 🐘 ReplyCommentController.php
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 CommentSettingController.php
│   │   │   │   │   │   ├── 🐘 CommentController.php
│   │   │   │   │   │   └── 🐘 ReplyCommentController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Fronts
│   │   │   │   │       │   ├── 🐘 CommentReferenceRequest.php
│   │   │   │   │       │   ├── 🐘 CommentRequest.php
│   │   │   │   │       │   └── 🐘 ReplyCommentRequest.php
│   │   │   │   │       ├── 📁 Settings
│   │   │   │   │       │   └── 🐘 CommentSettingRequest.php
│   │   │   │   │       ├── 🐘 CommentReferenceRequest.php
│   │   │   │   │       ├── 🐘 CommentRequest.php
│   │   │   │   │       └── 🐘 ReplyCommentRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 Comment.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 CommentServiceProvider.php
│   │   │   │   ├── 📁 Support
│   │   │   │   │   └── 🐘 CommentHelper.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 CommentTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 contact
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 email.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2016_06_17_091537_create_contacts_table.php
│   │   │   │       ├── 🐘 2023_11_10_080225_migrate_contact_blacklist_email_domains_to_core.php
│   │   │   │       ├── 🐘 2024_03_20_080001_migrate_change_attribute_email_to_nullable_form_contacts_table.php
│   │   │   │       ├── 🐘 2024_03_25_000001_update_captcha_settings_for_contact.php
│   │   │   │       └── 🐘 2024_04_19_063914_create_custom_fields_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   ├── 🎨 contact-public.css
│   │   │   │   │   └── 🎨 contact.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 contact-public.js
│   │   │   │       ├── 📄 contact.js
│   │   │   │       └── 📄 custom-field.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 email-templates
│   │   │   │   │   ├── 📄 admin-reply.tpl
│   │   │   │   │   ├── 📄 notice.tpl
│   │   │   │   │   └── 📄 sender-confirmation.tpl
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 contact-public.js
│   │   │   │   │   ├── 📄 contact.js
│   │   │   │   │   └── 📄 custom-field.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   ├── 🎨 contact-public.scss
│   │   │   │   │   └── 🎨 contact.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 forms
│   │   │   │       │   ├── 🐘 contact.blade.php
│   │   │   │       │   └── 🐘 old-version-support.blade.php
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 custom-field-options-footer.blade.php
│   │   │   │       │   ├── 🐘 custom-field-options.blade.php
│   │   │   │       │   └── 🐘 notification.blade.php
│   │   │   │       ├── 🐘 contact-info.blade.php
│   │   │   │       ├── 🐘 navbar-contact-badge-count.blade.php
│   │   │   │       └── 🐘 reply-box.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Seeders
│   │   │   │   │       └── 🐘 ContactSeeder.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   ├── 🐘 ContactStatusEnum.php
│   │   │   │   │   └── 🐘 CustomFieldType.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 SentContactEvent.php
│   │   │   │   ├── 📁 Exports
│   │   │   │   │   └── 🐘 ContactExport.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   └── 🐘 ContactForm.php
│   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   └── 🐘 ContactSettingForm.php
│   │   │   │   │   ├── 🐘 ContactForm.php
│   │   │   │   │   ├── 🐘 CustomFieldForm.php
│   │   │   │   │   └── 🐘 ShortcodeContactAdminConfigForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 ContactSettingController.php
│   │   │   │   │   │   ├── 🐘 ContactController.php
│   │   │   │   │   │   ├── 🐘 CustomFieldController.php
│   │   │   │   │   │   └── 🐘 PublicController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Settings
│   │   │   │   │       │   └── 🐘 ContactSettingRequest.php
│   │   │   │   │       ├── 🐘 ContactReplyRequest.php
│   │   │   │   │       ├── 🐘 ContactRequest.php
│   │   │   │   │       ├── 🐘 CustomFieldRequest.php
│   │   │   │   │       └── 🐘 EditContactRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 Contact.php
│   │   │   │   │   ├── 🐘 ContactReply.php
│   │   │   │   │   ├── 🐘 CustomField.php
│   │   │   │   │   └── 🐘 CustomFieldOption.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 ContactServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 ContactCacheDecorator.php
│   │   │   │   │   │   └── 🐘 ContactReplyCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 ContactReplyRepository.php
│   │   │   │   │   │   └── 🐘 ContactRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 ContactInterface.php
│   │   │   │   │       └── 🐘 ContactReplyInterface.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   ├── 🐘 ContactTable.php
│   │   │   │   │   └── 🐘 CustomFieldTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 cookie-consent
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 general.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 index.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Traits
│   │   │   │   │       └── 🐘 HasCookieConsentSeeder.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 CookieConsentServiceProvider.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 custom-field
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2017_03_27_150646_re_create_custom_field_tables.php
│   │   │   │       └── 🐘 2022_04_30_030807_table_custom_fields_translation_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   ├── 🐘 front.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   ├── 🎨 custom-field.css
│   │   │   │   │   └── 🎨 edit-field-group.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 edit-field-group.js
│   │   │   │       ├── 📄 import-field-group.js
│   │   │   │       └── 📄 use-custom-fields.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 edit-field-group.js
│   │   │   │   │   ├── 📄 import-field-group.js
│   │   │   │   │   └── 📄 use-custom-fields.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   ├── 🎨 custom-field.scss
│   │   │   │   │   └── 🎨 edit-field-group.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 _partials
│   │   │   │       │   ├── 🐘 export-button.blade.php
│   │   │   │       │   └── 🐘 import.blade.php
│   │   │   │       ├── 📁 _script-templates
│   │   │   │       │   ├── 🐘 edit-field-group-items.blade.php
│   │   │   │       │   ├── 🐘 render-custom-fields.blade.php
│   │   │   │       │   └── 🐘 rules.blade.php
│   │   │   │       ├── 🐘 custom-fields-boxes-renderer.blade.php
│   │   │   │       ├── 🐘 field-items-list.blade.php
│   │   │   │       ├── 🐘 list.blade.php
│   │   │   │       └── 🐘 rules.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Actions
│   │   │   │   │   ├── 🐘 AbstractAction.php
│   │   │   │   │   ├── 🐘 CreateCustomFieldAction.php
│   │   │   │   │   ├── 🐘 DeleteCustomFieldAction.php
│   │   │   │   │   ├── 🐘 ExportCustomFieldsAction.php
│   │   │   │   │   ├── 🐘 ImportCustomFieldsAction.php
│   │   │   │   │   └── 🐘 UpdateCustomFieldAction.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 CustomField.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 CustomFieldForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 CustomFieldController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 CreateFieldGroupRequest.php
│   │   │   │   │       └── 🐘 UpdateFieldGroupRequest.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 CreatedContentListener.php
│   │   │   │   │   ├── 🐘 DeletedContentListener.php
│   │   │   │   │   └── 🐘 UpdatedContentListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 CustomField.php
│   │   │   │   │   ├── 🐘 FieldGroup.php
│   │   │   │   │   └── 🐘 FieldItem.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 CustomFieldServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 CustomFieldCacheDecorator.php
│   │   │   │   │   │   ├── 🐘 FieldGroupCacheDecorator.php
│   │   │   │   │   │   └── 🐘 FieldItemCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 CustomFieldRepository.php
│   │   │   │   │   │   ├── 🐘 FieldGroupRepository.php
│   │   │   │   │   │   └── 🐘 FieldItemRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 CustomFieldInterface.php
│   │   │   │   │       ├── 🐘 FieldGroupInterface.php
│   │   │   │   │       └── 🐘 FieldItemInterface.php
│   │   │   │   ├── 📁 Support
│   │   │   │   │   └── 🐘 CustomFieldSupport.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   ├── 📁 Actions
│   │   │   │   │   │   └── 🐘 ExportAction.php
│   │   │   │   │   └── 🐘 CustomFieldTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 edit-lock
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 general.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 edit-lock.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 assets
│   │   │   │   │   └── 📁 js
│   │   │   │   │       └── 📄 edit-lock.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 footer.blade.php
│   │   │   │       ├── 🐘 modal-body.blade.php
│   │   │   │       └── 🐘 notification.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 EditLockFacade.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 BeforeEditContentListener.php
│   │   │   │   │   ├── 🐘 BeforeUpdateContentListener.php
│   │   │   │   │   └── 🐘 UpdatedContentListener.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EditLockServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   └── 🐘 EditLock.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 email-log
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2023_05_03_132833_create_email_logs_table.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 📁 email-logs
│   │   │   │           └── 🐘 show.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 EmailLogForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   └── 📁 Controllers
│   │   │   │   │       └── 🐘 EmailLogController.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 EmailLogger.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 EmailLog.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EmailLogServiceProvider.php
│   │   │   │   │   └── 🐘 EventServiceProvider.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 EmailLogTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📝 LICENSE.md
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 fob-comment
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2024_01_16_050056_create_comments_table.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 comment.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 comment.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 comment.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 comment.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 list.blade.php
│   │   │   │       │   └── 🐘 permalink.blade.php
│   │   │   │       ├── 📁 tables
│   │   │   │       │   ├── 🐘 author-column.blade.php
│   │   │   │       │   ├── 🐘 content-column.blade.php
│   │   │   │       │   ├── 🐘 reply-button.blade.php
│   │   │   │       │   └── 🐘 table.blade.php
│   │   │   │       └── 🐘 comment.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Actions
│   │   │   │   │   ├── 🐘 CreateNewComment.php
│   │   │   │   │   └── 🐘 GetCommentReference.php
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Seeders
│   │   │   │   │       └── 🐘 CommentSeeder.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 CommentStatus.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   └── 🐘 CommentForm.php
│   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   └── 🐘 CommentSettingForm.php
│   │   │   │   │   ├── 🐘 CommentForm.php
│   │   │   │   │   └── 🐘 ReplyCommentForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   │   ├── 🐘 CommentController.php
│   │   │   │   │   │   │   └── 🐘 ReplyCommentController.php
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 CommentSettingController.php
│   │   │   │   │   │   ├── 🐘 CommentController.php
│   │   │   │   │   │   └── 🐘 ReplyCommentController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Fronts
│   │   │   │   │       │   ├── 🐘 CommentReferenceRequest.php
│   │   │   │   │       │   ├── 🐘 CommentRequest.php
│   │   │   │   │       │   └── 🐘 ReplyCommentRequest.php
│   │   │   │   │       ├── 📁 Settings
│   │   │   │   │       │   └── 🐘 CommentSettingRequest.php
│   │   │   │   │       ├── 🐘 CommentReferenceRequest.php
│   │   │   │   │       ├── 🐘 CommentRequest.php
│   │   │   │   │       └── 🐘 ReplyCommentRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 Comment.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 CommentServiceProvider.php
│   │   │   │   ├── 📁 Support
│   │   │   │   │   └── 🐘 CommentHelper.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 CommentTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ .editorconfig
│   │   │   ├── ⚙️ .gitattributes
│   │   │   ├── ⚙️ .gitignore
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 gallery
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2016_10_13_150201_create_galleries_table.php
│   │   │   │       ├── 🐘 2021_12_03_082953_create_gallery_translations.php
│   │   │   │       ├── 🐘 2022_04_30_034048_create_gallery_meta_translations_table.php
│   │   │   │       └── 🐘 2023_08_29_075308_make_column_user_id_nullable.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   ├── 🎨 admin-gallery.css
│   │   │   │   │   ├── 🎨 gallery.css
│   │   │   │   │   └── 🎨 object-gallery.css
│   │   │   │   ├── 📁 fonts
│   │   │   │   │   ├── 📄 lg.eot
│   │   │   │   │   └── 📄 lg.woff
│   │   │   │   ├── 📁 images
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 gallery-admin.js
│   │   │   │   │   ├── 📄 gallery.js
│   │   │   │   │   └── 📄 object-gallery.js
│   │   │   │   └── 📁 libraries
│   │   │   │       ├── 📁 lightgallery
│   │   │   │       │   ├── 📁 css
│   │   │   │       │   ├── 📁 fonts
│   │   │   │       │   │   ├── 📄 lg.eot
│   │   │   │       │   │   └── 📄 lg.woff
│   │   │   │       │   ├── 📁 img
│   │   │   │       │   └── 📁 js
│   │   │   │       └── 📁 owl-carousel
│   │   │   │           ├── 🎨 owl.carousel.css
│   │   │   │           └── 📄 owl.carousel.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 gallery-admin.js
│   │   │   │   │   ├── 📄 gallery.js
│   │   │   │   │   └── 📄 object-gallery.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   ├── 🎨 admin-gallery.scss
│   │   │   │   │   ├── 🎨 gallery.scss
│   │   │   │   │   └── 🎨 object-gallery.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   └── 🐘 object-gallery.blade.php
│   │   │   │       ├── 📁 shortcodes
│   │   │   │       │   ├── 🐘 gallery-skeleton.blade.php
│   │   │   │       │   └── 🐘 gallery.blade.php
│   │   │   │       ├── 📁 themes
│   │   │   │       │   ├── 🐘 galleries.blade.php
│   │   │   │       │   └── 🐘 gallery.blade.php
│   │   │   │       └── 🐘 gallery-box.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Traits
│   │   │   │   │       └── 🐘 HasGallerySeeder.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 Gallery.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 GalleryForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 GalleryController.php
│   │   │   │   │   │   └── 🐘 PublicController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 GalleryRequest.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 CreatedContentListener.php
│   │   │   │   │   ├── 🐘 DeletedContentListener.php
│   │   │   │   │   ├── 🐘 RenderingSiteMapListener.php
│   │   │   │   │   └── 🐘 UpdatedContentListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 Gallery.php
│   │   │   │   │   └── 🐘 GalleryMeta.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 GalleryServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 GalleryCacheDecorator.php
│   │   │   │   │   │   └── 🐘 GalleryMetaCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 GalleryMetaRepository.php
│   │   │   │   │   │   └── 🐘 GalleryRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 GalleryInterface.php
│   │   │   │   │       └── 🐘 GalleryMetaInterface.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 GalleryService.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 GalleryTable.php
│   │   │   │   ├── 🐘 GallerySupport.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 geo-data-detector
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 images
│   │   │   ├── 📁 resources
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 📁 Settings
│   │   │   │   │       └── 🐘 GeoDataDetectorSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 GeoDataDetectorSettingController.php
│   │   │   │   │   │   └── 🐘 GeoDataDetectorController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 📁 Settings
│   │   │   │   │           └── 🐘 GeoDataDetectorSettingRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 GeoDataDetectorServiceProvider.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 google-maps-geocoding
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 geocoding.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 geocoding.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 geocoding.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 geocoding.scss
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 geocoding-script.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 📁 Settings
│   │   │   │   │       └── 🐘 GoogleMapsGeocodingSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 📁 Settings
│   │   │   │   │   │       └── 🐘 GoogleMapsGeocodingSettingController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 📁 Settings
│   │   │   │   │           └── 🐘 GoogleMapsGeocodingSettingRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 GoogleMapsGeocodingServiceProvider.php
│   │   │   │   │   └── 🐘 HookServiceProvider.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 hide-activated-license-info
│   │   │   ├── 📁 src
│   │   │   │   ├── 🐘 HideActivatedLicenseInfoProvider.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 impersonate
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 config.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 images
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 leave-impersonate.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 LeaveImpersonation.php
│   │   │   │   │   └── 🐘 TakeImpersonation.php
│   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   ├── 🐘 InvalidUserProvider.php
│   │   │   │   │   └── 🐘 MissingUserProvider.php
│   │   │   │   ├── 📁 Guard
│   │   │   │   │   └── 🐘 SessionGuard.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   └── 📁 Controllers
│   │   │   │   │       └── 🐘 ImpersonateController.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 ImpersonateServiceProvider.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 ImpersonateManager.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📝 readme.md
│   │   ├── 📁 ip-blocker
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2023_05_25_050133_create_ip_blocker_logs_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 errors
│   │   │   │       │   └── 🐘 403.blade.php
│   │   │   │       ├── 📁 tables
│   │   │   │       │   └── 🐘 simple-table.blade.php
│   │   │   │       └── 🐘 settings.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 IpBlockerController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   └── 🐘 IpBlockerMiddleware.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 AvailableCountriesRequest.php
│   │   │   │   │       ├── 🐘 CheckSecretKeyRequest.php
│   │   │   │   │       └── 🐘 UpdateSettingsRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 History.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 IpBlockerServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 IpBlockerCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 IpBlockerRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 IpBlockerInterface.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 HistoryTable.php
│   │   │   │   ├── 🐘 IpBlocker.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 location
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2019_11_18_061011_create_country_table.php
│   │   │   │       ├── 🐘 2021_12_03_084118_create_location_translations.php
│   │   │   │       ├── 🐘 2021_12_03_094518_migrate_old_location_data.php
│   │   │   │       ├── 🐘 2021_12_10_034440_switch_plugin_location_to_use_language_advanced.php
│   │   │   │       ├── 🐘 2022_01_16_085908_improve_plugin_location.php
│   │   │   │       ├── 🐘 2022_08_04_052122_delete_location_backup_tables.php
│   │   │   │       ├── 🐘 2023_04_23_061847_increase_state_translations_abbreviation_column.php
│   │   │   │       ├── 🐘 2023_07_26_041451_add_more_columns_to_location_table.php
│   │   │   │       ├── 🐘 2023_07_27_041451_add_more_columns_to_location_translation_table.php
│   │   │   │       ├── 🐘 2023_08_15_073307_drop_unique_in_states_cities_translations.php
│   │   │   │       └── 🐘 2023_10_21_065016_make_state_id_in_table_cities_nullable.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 bulk-import.js
│   │   │   │       └── 📄 location.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 bulk-import.js
│   │   │   │   │   └── 📄 location.js
│   │   │   │   └── 📁 views
│   │   │   │       └── 📁 partials
│   │   │   │           └── 🐘 import-available-data.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   └── 🐘 MigrateLocationCommand.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 ImportType.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   ├── 🐘 DownloadedCities.php
│   │   │   │   │   ├── 🐘 DownloadedCountry.php
│   │   │   │   │   ├── 🐘 DownloadedStates.php
│   │   │   │   │   ├── 🐘 ImportedCityEvent.php
│   │   │   │   │   ├── 🐘 ImportedCountryEvent.php
│   │   │   │   │   └── 🐘 ImportedStateEvent.php
│   │   │   │   ├── 📁 Exporters
│   │   │   │   │   └── 🐘 LocationExporter.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 Location.php
│   │   │   │   ├── 📁 Fields
│   │   │   │   │   ├── 📁 Options
│   │   │   │   │   │   └── 🐘 SelectLocationFieldOption.php
│   │   │   │   │   └── 🐘 SelectLocationField.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 🐘 CityForm.php
│   │   │   │   │   ├── 🐘 CountryForm.php
│   │   │   │   │   └── 🐘 StateForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 CityController.php
│   │   │   │   │   │   ├── 🐘 CountryController.php
│   │   │   │   │   │   ├── 🐘 ExportLocationController.php
│   │   │   │   │   │   ├── 🐘 ImportLocationController.php
│   │   │   │   │   │   └── 🐘 StateController.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   ├── 🐘 CityRequest.php
│   │   │   │   │   │   ├── 🐘 CountryRequest.php
│   │   │   │   │   │   ├── 🐘 ImportLocationRequest.php
│   │   │   │   │   │   └── 🐘 StateRequest.php
│   │   │   │   │   └── 📁 Resources
│   │   │   │   │       ├── 🐘 CityResource.php
│   │   │   │   │       ├── 🐘 CountryResource.php
│   │   │   │   │       └── 🐘 StateResource.php
│   │   │   │   ├── 📁 Importers
│   │   │   │   │   └── 🐘 LocationImporter.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   ├── 🐘 CreateCityTranslationListener.php
│   │   │   │   │   ├── 🐘 CreateCountryTranslationListener.php
│   │   │   │   │   └── 🐘 CreateStateTranslationListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 City.php
│   │   │   │   │   ├── 🐘 Country.php
│   │   │   │   │   └── 🐘 State.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 LocationServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 CityCacheDecorator.php
│   │   │   │   │   │   ├── 🐘 CountryCacheDecorator.php
│   │   │   │   │   │   └── 🐘 StateCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 CityRepository.php
│   │   │   │   │   │   ├── 🐘 CountryRepository.php
│   │   │   │   │   │   └── 🐘 StateRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 CityInterface.php
│   │   │   │   │       ├── 🐘 CountryInterface.php
│   │   │   │   │       └── 🐘 StateInterface.php
│   │   │   │   ├── 📁 Rules
│   │   │   │   │   ├── 🐘 CityRule.php
│   │   │   │   │   └── 🐘 StateRule.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   └── 🐘 ImportLocationService.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   ├── 🐘 CityTable.php
│   │   │   │   │   ├── 🐘 CountryTable.php
│   │   │   │   │   └── 🐘 StateTable.php
│   │   │   │   ├── 🐘 Location.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 maintenance-mode
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 images
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 maintenance.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 assets
│   │   │   │   │   └── 📁 js
│   │   │   │   │       └── 📄 maintenance.js
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 maintenance.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 MaintenanceModeController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 MaintenanceModeRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 MaintenanceModeServiceProvider.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   └── 🐘 MaintenanceMode.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   ├── 📝 readme.md
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 member
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 email.php
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2017_10_04_140938_create_member_table.php
│   │   │   │       ├── 🐘 2023_10_16_075332_add_status_column.php
│   │   │   │       └── 🐘 2024_03_25_000001_update_captcha_settings.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   ├── 📁 dashboard
│   │   │   │   │   │   ├── 🎨 style-rtl.css
│   │   │   │   │   │   └── 🎨 style.css
│   │   │   │   │   ├── 🎨 app.css
│   │   │   │   │   └── 🎨 front-auth.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📁 dashboard
│   │   │   │       │   ├── 📄 activity-logs.js
│   │   │   │       │   └── 📄 script.js
│   │   │   │       └── 📄 member-admin.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 email-templates
│   │   │   │   │   ├── 📄 confirm-email.tpl
│   │   │   │   │   ├── 📄 new-pending-post.tpl
│   │   │   │   │   └── 📄 password-reminder.tpl
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📁 dashboard
│   │   │   │   │   │   ├── 📁 components
│   │   │   │   │   │   │   └── 📄 ActivityLogComponent.vue
│   │   │   │   │   │   ├── 📄 activity-logs.js
│   │   │   │   │   │   └── 📄 script.js
│   │   │   │   │   └── 📄 member-admin.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   ├── 📁 dashboard
│   │   │   │   │   │   ├── 🎨 style-rtl.scss
│   │   │   │   │   │   └── 🎨 style.scss
│   │   │   │   │   └── 🎨 front-auth.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 auth
│   │   │   │       │   ├── 📁 passwords
│   │   │   │       │   │   ├── 🐘 email.blade.php
│   │   │   │       │   │   └── 🐘 reset.blade.php
│   │   │   │       │   └── 🐘 register.blade.php
│   │   │   │       ├── 📁 forms
│   │   │   │       │   ├── 🐘 auth.blade.php
│   │   │   │       │   └── 🐘 base.blade.php
│   │   │   │       ├── 📁 includes
│   │   │   │       │   ├── 🐘 notification.blade.php
│   │   │   │       │   ├── 🐘 register-link.blade.php
│   │   │   │       │   └── 🐘 submit.blade.php
│   │   │   │       ├── 📁 table
│   │   │   │       │   └── 🐘 base.blade.php
│   │   │   │       └── 📁 themes
│   │   │   │           ├── 📁 auth
│   │   │   │           │   ├── 📁 passwords
│   │   │   │           │   │   ├── 🐘 email.blade.php
│   │   │   │           │   │   └── 🐘 reset.blade.php
│   │   │   │           │   └── 🐘 register.blade.php
│   │   │   │           ├── 📁 dashboard
│   │   │   │           │   ├── 📁 layouts
│   │   │   │           │   │   ├── 🐘 body.blade.php
│   │   │   │           │   │   ├── 🐘 footer.blade.php
│   │   │   │           │   │   ├── 🐘 header-meta.blade.php
│   │   │   │           │   │   ├── 🐘 header.blade.php
│   │   │   │           │   │   ├── 🐘 master.blade.php
│   │   │   │           │   │   └── 🐘 menu.blade.php
│   │   │   │           │   ├── 📁 settings
│   │   │   │           │   │   ├── 📁 partials
│   │   │   │           │   │   │   └── 🐘 email-status.blade.php
│   │   │   │           │   │   └── 🐘 index.blade.php
│   │   │   │           │   └── 🐘 index.blade.php
│   │   │   │           └── 🐘 author.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   ├── 🐘 member.php
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Seeders
│   │   │   │   │       └── 🐘 MemberSeeder.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   └── 🐘 CustomEditorField.php
│   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   ├── 📁 Auth
│   │   │   │   │   │   │   ├── 📁 FieldOptions
│   │   │   │   │   │   │   │   ├── 🐘 EmailFieldOption.php
│   │   │   │   │   │   │   │   ├── 🐘 HasIcon.php
│   │   │   │   │   │   │   │   └── 🐘 TextFieldOption.php
│   │   │   │   │   │   │   ├── 🐘 AuthForm.php
│   │   │   │   │   │   │   ├── 🐘 ForgotPasswordForm.php
│   │   │   │   │   │   │   ├── 🐘 RegisterForm.php
│   │   │   │   │   │   │   └── 🐘 ResetPasswordForm.php
│   │   │   │   │   │   ├── 🐘 ChangePasswordForm.php
│   │   │   │   │   │   └── 🐘 ProfileForm.php
│   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   └── 🐘 MemberSettingForm.php
│   │   │   │   │   ├── 🐘 MemberForm.php
│   │   │   │   │   └── 🐘 PostForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 MemberSettingController.php
│   │   │   │   │   │   ├── 🐘 ForgotPasswordController.php
│   │   │   │   │   │   ├── 🐘 MemberController.php
│   │   │   │   │   │   ├── 🐘 PostController.php
│   │   │   │   │   │   ├── 🐘 PublicController.php
│   │   │   │   │   │   ├── 🐘 RegisterController.php
│   │   │   │   │   │   └── 🐘 ResetPasswordController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   ├── 🐘 RedirectIfMember.php
│   │   │   │   │   │   └── 🐘 RedirectIfNotMember.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   │   └── 📁 Auth
│   │   │   │   │   │   │       ├── 🐘 ForgotPasswordRequest.php
│   │   │   │   │   │   │       ├── 🐘 RegisterRequest.php
│   │   │   │   │   │   │       └── 🐘 ResetPasswordRequest.php
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 MemberSettingRequest.php
│   │   │   │   │   │   ├── 🐘 AvatarRequest.php
│   │   │   │   │   │   ├── 🐘 MemberCreateRequest.php
│   │   │   │   │   │   ├── 🐘 MemberEditRequest.php
│   │   │   │   │   │   ├── 🐘 PostRequest.php
│   │   │   │   │   │   ├── 🐘 SettingRequest.php
│   │   │   │   │   │   └── 🐘 UpdatePasswordRequest.php
│   │   │   │   │   └── 📁 Resources
│   │   │   │   │       └── 🐘 ActivityLogResource.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 UpdatedContentListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 Member.php
│   │   │   │   │   └── 🐘 MemberActivityLog.php
│   │   │   │   ├── 📁 Notifications
│   │   │   │   │   ├── 🐘 ConfirmEmailNotification.php
│   │   │   │   │   └── 🐘 ResetPasswordNotification.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   └── 🐘 MemberServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 MemberActivityLogCacheDecorator.php
│   │   │   │   │   │   └── 🐘 MemberCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 MemberActivityLogRepository.php
│   │   │   │   │   │   └── 🐘 MemberRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 MemberActivityLogInterface.php
│   │   │   │   │       └── 🐘 MemberInterface.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   ├── 📁 Traits
│   │   │   │   │   │   └── 🐘 ForMember.php
│   │   │   │   │   ├── 🐘 MemberTable.php
│   │   │   │   │   └── 🐘 PostTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 my-style
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 config.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 css-editor.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 MyStyleHelperFacade.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 MyStyleServiceProvider.php
│   │   │   │   ├── 🐘 MyStyleHelper.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 post-scheduler
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 general.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 images
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 publish-box.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 PostScheduler.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 PostSchedulerServiceProvider.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   └── 🐘 PostScheduler.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📝 readme.md
│   │   ├── 📁 pwa
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 pwa
│   │   │   │   │   └── 🌐 offline.html
│   │   │   │   └── 📄 service-worker.js
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 footer-script.blade.php
│   │   │   │       └── 🐘 header-meta.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   ├── 🐘 ClearPwaCacheCommand.php
│   │   │   │   │   └── 🐘 PublishPwaAssetsCommand.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 PwaSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 📁 Settings
│   │   │   │   │   │       └── 🐘 PwaSettingController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 PwaSettingRequest.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 PublishPwaAssets.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 PwaServiceProvider.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ .gitattributes
│   │   │   ├── ⚙️ .gitignore
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 request-log
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2016_05_28_112028_create_system_request_logs_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 request-log.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 request-log.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 widgets
│   │   │   │       │   └── 🐘 request-errors.blade.php
│   │   │   │       └── 🐘 table.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Commands
│   │   │   │   │   └── 🐘 RequestLogClearCommand.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 RequestHandlerEvent.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   └── 📁 Controllers
│   │   │   │   │       └── 🐘 RequestLogController.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 RequestHandlerListener.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 RequestLog.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 CommandServiceProvider.php
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 RequestLogServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   └── 🐘 RequestLogCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   └── 🐘 RequestLogRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       └── 🐘 RequestLogInterface.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 RequestLogTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 request-quote
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 email.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2024_01_01_000001_create_request_quotes_table.php
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 email-templates
│   │   │   │   │   ├── 📄 admin-notification.tpl
│   │   │   │   │   └── 📄 customer-confirmation.tpl
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 button.blade.php
│   │   │   │       ├── 🐘 modal.blade.php
│   │   │   │       └── 🐘 show.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Database
│   │   │   │   │   └── 📁 Seeders
│   │   │   │   │       └── 🐘 RequestQuoteSeeder.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 RequestQuoteStatusEnum.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   └── 🐘 RequestQuoteForm.php
│   │   │   │   │   └── 📁 Settings
│   │   │   │   │       └── 🐘 RequestQuoteSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 RequestQuoteSettingController.php
│   │   │   │   │   │   ├── 🐘 PublicRequestQuoteController.php
│   │   │   │   │   │   └── 🐘 RequestQuoteController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Settings
│   │   │   │   │       │   └── 🐘 RequestQuoteSettingRequest.php
│   │   │   │   │       └── 🐘 RequestQuoteRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 RequestQuote.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 RequestQuoteServiceProvider.php
│   │   │   │   └── 📁 Tables
│   │   │   │       └── 🐘 RequestQuoteTable.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 rss-feed
│   │   │   ├── 📁 art
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 rss-feed.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 atom.blade.php
│   │   │   │       ├── 🐘 json.blade.php
│   │   │   │       ├── 🐘 links.blade.php
│   │   │   │       └── 🐘 rss.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   └── 🐘 Feedable.php
│   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   └── 🐘 InvalidFeedItem.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 RssFeed.php
│   │   │   │   ├── 📁 Helpers
│   │   │   │   │   ├── 🐘 Cdata.php
│   │   │   │   │   └── 🐘 FeedContentType.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   └── 📁 Controllers
│   │   │   │   │       └── 🐘 RssFeedController.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 RssFeedServiceProvider.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   └── 🐘 RssFeed.php
│   │   │   │   ├── 🐘 Feed.php
│   │   │   │   ├── 🐘 FeedItem.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 sanctum-token
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 table.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 SanctumTokenForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 SanctumTokenController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 StoreSanctumTokenRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 PersonalAccessToken.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 SanctumTokenServiceProvider.php
│   │   │   │   └── 📁 Tables
│   │   │   │       └── 🐘 SanctumTokenTable.php
│   │   │   ├── ⚙️ .gitignore
│   │   │   ├── 📝 LICENSE.md
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 sms-gateway
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2024_07_29_164638_create_fob_otps_table.php
│   │   │   │       └── 🐘 2024_07_31_025057_create_fob_sms_logs_table.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 images
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 sms.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 sms.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 instructions
│   │   │   │       │   ├── 🐘 msg91.blade.php
│   │   │   │       │   ├── 🐘 nexmo.blade.php
│   │   │   │       │   └── 🐘 twilio.blade.php
│   │   │   │       ├── 📁 phone-verification
│   │   │   │       │   ├── 🐘 resend.blade.php
│   │   │   │       │   └── 🐘 verify.blade.php
│   │   │   │       └── 🐘 index.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Actions
│   │   │   │   │   └── 🐘 SendOtpAction.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   ├── 🐘 Driver.php
│   │   │   │   │   ├── 🐘 Factory.php
│   │   │   │   │   └── 🐘 Otp.php
│   │   │   │   ├── 📁 DataTransferObjects
│   │   │   │   │   └── 🐘 SmsResponse.php
│   │   │   │   ├── 📁 Drivers
│   │   │   │   │   ├── 🐘 AbstractDriver.php
│   │   │   │   │   ├── 🐘 Msg91.php
│   │   │   │   │   ├── 🐘 Nexmo.php
│   │   │   │   │   └── 🐘 Twilio.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   └── 🐘 SmsStatus.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   ├── 🐘 Guard.php
│   │   │   │   │   ├── 🐘 Otp.php
│   │   │   │   │   └── 🐘 Sms.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 🐘 Msg91GatewayForm.php
│   │   │   │   │   ├── 🐘 NexmoGatewayForm.php
│   │   │   │   │   ├── 🐘 PhoneVerificationForm.php
│   │   │   │   │   ├── 🐘 SmsGatewayForm.php
│   │   │   │   │   ├── 🐘 SmsSettingForm.php
│   │   │   │   │   └── 🐘 TwilioGatewayForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 PhoneVerificationController.php
│   │   │   │   │   │   ├── 🐘 ResendOtpController.php
│   │   │   │   │   │   ├── 🐘 SmsController.php
│   │   │   │   │   │   └── 🐘 SmsLogController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   │   ├── 🐘 EnsurePhoneIsVerified.php
│   │   │   │   │   │   └── 🐘 RedirectIfPhoneIsVerified.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 PhoneVerificationRequest.php
│   │   │   │   │       ├── 🐘 SmsSettingRequest.php
│   │   │   │   │       └── 🐘 SmsTestRequest.php
│   │   │   │   ├── 📁 Listeners
│   │   │   │   │   └── 🐘 SendOtpNotification.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 SmsLog.php
│   │   │   │   │   └── 🐘 SmsOtp.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   └── 🐘 SmsServiceProvider.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 SmsLogTable.php
│   │   │   │   ├── 🐘 GuardManager.php
│   │   │   │   ├── 🐘 OtpGenerator.php
│   │   │   │   ├── 🐘 Plugin.php
│   │   │   │   └── 🐘 SmsManager.php
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 social-login
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2025_04_08_040931_create_social_logins_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 social-login.css
│   │   │   │   ├── 📁 images
│   │   │   │   │   ├── 📁 icons
│   │   │   │   │   └── 📁 styles
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 social-login.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 social-login.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 google-sign-in-button.blade.php
│   │   │   │       └── 🐘 social-login-item.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   ├── 🐘 api.php
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Console
│   │   │   │   │   └── 🐘 RefreshSocialTokensCommand.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 SocialService.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 SocialLoginSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 API
│   │   │   │   │   │   │   ├── 🐘 AppleLoginController.php
│   │   │   │   │   │   │   ├── 🐘 FacebookLoginController.php
│   │   │   │   │   │   │   ├── 🐘 GoogleLoginController.php
│   │   │   │   │   │   │   └── 🐘 XLoginController.php
│   │   │   │   │   │   ├── 📁 Settings
│   │   │   │   │   │   │   └── 🐘 SocialLoginSettingController.php
│   │   │   │   │   │   ├── 🐘 FacebookDataDeletionRequestCallbackController.php
│   │   │   │   │   │   └── 🐘 SocialLoginController.php
│   │   │   │   │   ├── 📁 Middleware
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Settings
│   │   │   │   │       │   └── 🐘 SocialLoginSettingRequest.php
│   │   │   │   │       └── 🐘 FacebookDataDeletionRequestCallbackRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 SocialLogin.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 SocialLoginServiceProvider.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   ├── 🐘 AppleJwtService.php
│   │   │   │   │   └── 🐘 SocialLoginService.php
│   │   │   │   ├── 📁 Supports
│   │   │   │   │   ├── 🐘 FacebookDataDeletionSignedRequestParser.php
│   │   │   │   │   └── 🐘 SocialService.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 social-login-zalo
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 social-login-zalo.css
│   │   │   │   └── 📁 images
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 sass
│   │   │   │       └── 🎨 social-login-zalo.scss
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 SocialLoginZaloServiceProvider.php
│   │   │   │   ├── 🐘 Plugin.php
│   │   │   │   ├── 🐘 ZaloProvider.php
│   │   │   │   └── 🐘 ZaloUser.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 tag-cloud
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 images
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 widget
│   │   │   │       │   ├── 🐘 backend.blade.php
│   │   │   │       │   └── 🐘 frontend.blade.php
│   │   │   │       └── 🐘 footer.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 TagCloudServiceProvider.php
│   │   │   │   ├── 📁 Widgets
│   │   │   │   │   └── 🐘 TagCloud.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 ticksify
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2024_07_05_073401_create_fob_ticket_categories_table.php
│   │   │   │       ├── 🐘 2024_07_05_073407_create_fob_tickets_table.php
│   │   │   │       ├── 🐘 2024_07_05_073411_create_fob_ticket_messages_table.php
│   │   │   │       └── 🐘 2025_01_31_140629_make_category_nullable.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   ├── 🎨 front-ticksify.css
│   │   │   │   │   └── 🎨 ticksify.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 front-ticksify.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 front-ticksify.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   ├── 🎨 front-ticksify.scss
│   │   │   │   │   └── 🎨 ticksify.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 themes
│   │   │   │       │   ├── 📁 partials
│   │   │   │       │   │   ├── 🐘 pagination.blade.php
│   │   │   │       │   │   └── 🐘 stat.blade.php
│   │   │   │       │   └── 📁 tickets
│   │   │   │       │       ├── 🐘 create.blade.php
│   │   │   │       │       ├── 🐘 index.blade.php
│   │   │   │       │       └── 🐘 show.blade.php
│   │   │   │       └── 📁 tickets
│   │   │   │           ├── 📁 partials
│   │   │   │           │   └── 🐘 stats.blade.php
│   │   │   │           └── 🐘 show.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Actions
│   │   │   │   │   └── 🐘 StoreTicketMessageAction.php
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   └── 🐘 CanUseTickets.php
│   │   │   │   ├── 📁 Enums
│   │   │   │   │   ├── 🐘 TicketPriority.php
│   │   │   │   │   └── 🐘 TicketStatus.php
│   │   │   │   ├── 📁 Events
│   │   │   │   │   └── 🐘 MessageCreated.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   ├── 🐘 MessageForm.php
│   │   │   │   │   │   └── 🐘 TicketForm.php
│   │   │   │   │   ├── 🐘 CategoryForm.php
│   │   │   │   │   ├── 🐘 MessageForm.php
│   │   │   │   │   └── 🐘 TicketForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Fronts
│   │   │   │   │   │   │   ├── 🐘 TicketController.php
│   │   │   │   │   │   │   └── 🐘 TicketMessageController.php
│   │   │   │   │   │   ├── 🐘 CategoryController.php
│   │   │   │   │   │   ├── 🐘 MessageController.php
│   │   │   │   │   │   ├── 🐘 TicketController.php
│   │   │   │   │   │   └── 🐘 TicketMessageController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 📁 Fronts
│   │   │   │   │       │   ├── 🐘 TicketMessageRequest.php
│   │   │   │   │       │   └── 🐘 TicketRequest.php
│   │   │   │   │       ├── 🐘 CategoryRequest.php
│   │   │   │   │       ├── 🐘 MessageRequest.php
│   │   │   │   │       └── 🐘 TicketRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 Category.php
│   │   │   │   │   ├── 🐘 Message.php
│   │   │   │   │   └── 🐘 Ticket.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 TicksifyServiceProvider.php
│   │   │   │   ├── 📁 Seeders
│   │   │   │   │   └── 🐘 TicketSeeder.php
│   │   │   │   ├── 📁 Support
│   │   │   │   │   └── 🐘 Helper.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   ├── 🐘 CategoryTable.php
│   │   │   │   │   ├── 🐘 MessageTable.php
│   │   │   │   │   └── 🐘 TicketTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ package.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 toc
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 general.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 toc.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 toc.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 assets
│   │   │   │   │   ├── 📁 js
│   │   │   │   │   │   └── 📄 toc.js
│   │   │   │   │   └── 📁 sass
│   │   │   │   │       └── 🎨 toc.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 container.blade.php
│   │   │   │       ├── 🐘 options-in-form.blade.php
│   │   │   │       ├── 🐘 settings-v6.blade.php
│   │   │   │       └── 🐘 toc.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   ├── 🐘 ToCHelper.php
│   │   │   │   │   └── 🐘 ToCHelperFacade.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 📁 Settings
│   │   │   │   │       └── 🐘 ToCSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 ToCController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 ToCSettingRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 ToCServiceProvider.php
│   │   │   │   ├── 🐘 Plugin.php
│   │   │   │   └── 🐘 ToCHelper.php
│   │   │   ├── ⚙️ .gitattributes
│   │   │   ├── ⚙️ .gitignore
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 translation
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2016_10_07_193005_create_translations_table.php
│   │   │   │       └── 🐘 2023_12_12_105220_drop_translations_table.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   ├── 🎨 theme-translations.css
│   │   │   │   │   └── 🎨 translation.css
│   │   │   │   └── 📁 js
│   │   │   │       ├── 📄 locales.js
│   │   │   │       └── 📄 translation.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 dictionaries
│   │   │   │   │   ├── ⚙️ ar.json
│   │   │   │   │   ├── ⚙️ ko.json
│   │   │   │   │   └── ⚙️ vi.json
│   │   │   │   ├── 📁 js
│   │   │   │   │   ├── 📄 locales.js
│   │   │   │   │   └── 📄 translation.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 translation.scss
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 partials
│   │   │   │       │   ├── 🐘 available-remote-locales.blade.php
│   │   │   │       │   ├── 🐘 list-theme-languages-to-translate.blade.php
│   │   │   │       │   └── 🐘 locale-item.blade.php
│   │   │   │       ├── 🐘 index.blade.php
│   │   │   │       ├── 🐘 locales.blade.php
│   │   │   │       └── 🐘 theme-translations.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Console
│   │   │   │   │   ├── 🐘 AutoTranslateCoreCommand.php
│   │   │   │   │   ├── 🐘 AutoTranslateThemeCommand.php
│   │   │   │   │   ├── 🐘 CleanupTranslationsCommand.php
│   │   │   │   │   ├── 🐘 DownloadLocaleCommand.php
│   │   │   │   │   ├── 🐘 FindTranslationsByPathCommand.php
│   │   │   │   │   ├── 🐘 RemoveLocaleCommand.php
│   │   │   │   │   ├── 🐘 RemoveUnusedTranslationsCommand.php
│   │   │   │   │   └── 🐘 UpdateThemeTranslationCommand.php
│   │   │   │   ├── 📁 Exceptions
│   │   │   │   │   ├── 🐘 LargeTextException.php
│   │   │   │   │   ├── 🐘 RateLimitException.php
│   │   │   │   │   ├── 🐘 TranslationDecodingException.php
│   │   │   │   │   └── 🐘 TranslationRequestException.php
│   │   │   │   ├── 📁 Exporters
│   │   │   │   │   ├── 🐘 OtherTranslationExporter.php
│   │   │   │   │   └── 🐘 ThemeTranslationExporter.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 📁 Concerns
│   │   │   │   │   │   │   └── 🐘 HasMapTranslationsTable.php
│   │   │   │   │   │   ├── 🐘 ExportOtherTranslationController.php
│   │   │   │   │   │   ├── 🐘 ExportThemeTranslationController.php
│   │   │   │   │   │   ├── 🐘 ImportOtherTranslationController.php
│   │   │   │   │   │   ├── 🐘 ImportThemeTranslationController.php
│   │   │   │   │   │   ├── 🐘 LocaleController.php
│   │   │   │   │   │   ├── 🐘 ReImportThemeTranslationController.php
│   │   │   │   │   │   ├── 🐘 ThemeTranslationController.php
│   │   │   │   │   │   └── 🐘 TranslationController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 LocaleRequest.php
│   │   │   │   │       └── 🐘 TranslationRequest.php
│   │   │   │   ├── 📁 Importers
│   │   │   │   │   ├── 🐘 OtherTranslationImporter.php
│   │   │   │   │   └── 🐘 ThemeTranslationImporter.php
│   │   │   │   ├── 📁 PanelSections
│   │   │   │   │   └── 🐘 LocalizationPanelSection.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 TranslationServiceProvider.php
│   │   │   │   ├── 📁 Services
│   │   │   │   │   ├── 🐘 CreateLocaleService.php
│   │   │   │   │   ├── 🐘 DownloadLocaleService.php
│   │   │   │   │   ├── 🐘 GetGroupedTranslationsService.php
│   │   │   │   │   └── 🐘 GoogleTranslate.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   ├── 🐘 ThemeTranslationTable.php
│   │   │   │   │   └── 🐘 TranslationTable.php
│   │   │   │   ├── 📁 Tokens
│   │   │   │   │   ├── 🐘 GoogleTokenGenerator.php
│   │   │   │   │   └── 🐘 TokenProviderInterface.php
│   │   │   │   ├── 🐘 AutoTranslateManager.php
│   │   │   │   ├── 🐘 Dictionary.php
│   │   │   │   ├── 🐘 Manager.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 trix-editor
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 css
│   │   │   │   │   └── 🎨 trix.css
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 trix.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 js
│   │   │   │   │   └── 📄 trix.js
│   │   │   │   ├── 📁 sass
│   │   │   │   │   └── 🎨 trix.scss
│   │   │   │   └── 📁 views
│   │   │   │       └── 📁 forms
│   │   │   │           └── 📁 partials
│   │   │   │               └── 🐘 trix.blade.php
│   │   │   ├── 📁 src
│   │   │   │   └── 📁 Providers
│   │   │   │       └── 🐘 TrixEditorServiceProvider.php
│   │   │   ├── 📝 LICENSE.md
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ package.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 turnstile
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 forms
│   │   │   │       │   └── 📁 fields
│   │   │   │       │       └── 🐘 turnstile.blade.php
│   │   │   │       └── 🐘 script.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Contracts
│   │   │   │   │   └── 🐘 Turnstile.php
│   │   │   │   ├── 📁 Facades
│   │   │   │   │   └── 🐘 Turnstile.php
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   ├── 📁 Fields
│   │   │   │   │   │   └── 🐘 TurnstileField.php
│   │   │   │   │   └── 📁 Settings
│   │   │   │   │       └── 🐘 TurnstileSettingForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 📁 Settings
│   │   │   │   │   │       └── 🐘 TurnstileSettingController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 📁 Settings
│   │   │   │   │           └── 🐘 TurnstileSettingRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 TurnstileServiceProvider.php
│   │   │   │   ├── 📁 Rules
│   │   │   │   │   └── 🐘 Turnstile.php
│   │   │   │   └── 🐘 Turnstile.php
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 url-redirector
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       └── 🐘 2023_05_16_021200_create_url_redirectors_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 resources
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 UrlRedirectorForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 UrlRedirectorController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       ├── 🐘 StoreUrlRedirectorRequest.php
│   │   │   │   │       └── 🐘 UpdateUrlRedirectorRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   └── 🐘 UrlRedirector.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 UrlRedirectorServiceProvider.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 UrlRedirectorTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 url-shortener
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   ├── 📁 migrations
│   │   │   │   │   ├── 🐘 2019_05_03_074735_create_short_url_table.php
│   │   │   │   │   └── 🐘 2023_05_18_021624_short_url_analytics.php
│   │   │   │   └── 📄 GeoLite2-Country.mmdb
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       └── 📁 chart.js
│   │   │   │           └── 📄 Chart.extension.js
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 analytics.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 UrlShortenerForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 AnalyticsController.php
│   │   │   │   │   │   └── 🐘 UrlShortenerController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 UrlShortenerRequest.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 Analytics.php
│   │   │   │   │   └── 🐘 UrlShortener.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 UrlShortenerServiceProvider.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 UrlShortenerTable.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 CONTRIBUTING.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 vietnam-bank-qr
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       └── 🐘 bank-info.blade.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 VietnamBankQrServiceProvider.php
│   │   │   │   ├── 🐘 Plugin.php
│   │   │   │   └── 🐘 VietQR.php
│   │   │   ├── 📝 CHANGELOG.md
│   │   │   ├── 📄 LICENSE
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 vig-ai
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2023_03_15_221528_create_models_table.php
│   │   │   │       ├── 🐘 2023_03_17_233538_create_chats_table.php
│   │   │   │       ├── 🐘 2023_03_18_155642_create_completions_table.php
│   │   │   │       └── 🐘 2023_03_20_232708_create_images_table.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 js
│   │   │   │       └── 📄 vig-ai.js
│   │   │   ├── 📁 resources
│   │   │   │   ├── 📁 assets
│   │   │   │   │   └── 📁 js
│   │   │   │   │       ├── 📁 BlockAi
│   │   │   │   │       │   └── 📄 BlockAi.js
│   │   │   │   │       └── 📄 vig-ai.js
│   │   │   │   └── 📁 views
│   │   │   │       ├── 🐘 index.blade.php
│   │   │   │       └── 🐘 setting.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   └── 🐘 VigAiController.php
│   │   │   │   │   └── 📁 Requests
│   │   │   │   │       └── 🐘 VigAiRequest.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 VigAiServiceProvider.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 README.md
│   │   │   ├── ⚙️ composer.json
│   │   │   ├── ⚙️ package.json
│   │   │   ├── ⚙️ plugin.json
│   │   │   └── 📄 webpack.mix.js
│   │   ├── 📁 vig-reactions
│   │   │   ├── 📁 config
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 database
│   │   │   │   └── 📁 migrations
│   │   │   │       ├── 🐘 2020_06_16_204308_vig_reactions_create_vig_reactions_table.php
│   │   │   │       ├── 🐘 2020_06_17_168421_vig_reactions_column_session_table.php
│   │   │   │       ├── 🐘 2020_06_18_524144_vig_reactions_column_session_notnull.php
│   │   │   │       ├── 🐘 2022_08_17_144232_rename_column_reaction.php
│   │   │   │       └── 🐘 2022_08_29_153921_make_table_vig_reaction_meta.php
│   │   │   ├── 📁 helpers
│   │   │   │   ├── 🐘 constants.php
│   │   │   │   └── 🐘 helpers.php
│   │   │   ├── 📁 public
│   │   │   │   ├── 📁 icon
│   │   │   │   ├── 📁 style-1
│   │   │   │   │   ├── 📄 scripts.js
│   │   │   │   │   └── 🎨 style.css
│   │   │   │   ├── 📁 style-2
│   │   │   │   │   ├── 📄 scripts.js
│   │   │   │   │   └── 🎨 style.css
│   │   │   │   ├── 📁 style-4
│   │   │   │   │   ├── 📄 scripts.js
│   │   │   │   │   └── 🎨 style.css
│   │   │   │   └── 📄 reaction-recent.js
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 widgets
│   │   │   │       │   ├── 🐘 popular.blade.php
│   │   │   │       │   └── 🐘 recent.blade.php
│   │   │   │       ├── 🐘 actions.blade.php
│   │   │   │       ├── 🐘 style-1.blade.php
│   │   │   │       ├── 🐘 style-2.blade.php
│   │   │   │       ├── 🐘 style-3.blade.php
│   │   │   │       └── 🐘 style-4.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Forms
│   │   │   │   │   └── 🐘 VigReactionsForm.php
│   │   │   │   ├── 📁 Http
│   │   │   │   │   ├── 📁 Controllers
│   │   │   │   │   │   ├── 🐘 ActionController.php
│   │   │   │   │   │   └── 🐘 VigReactionsController.php
│   │   │   │   │   ├── 📁 Events
│   │   │   │   │   │   └── 🐘 CreateOrUpdateReactionEvent.php
│   │   │   │   │   ├── 📁 Listeners
│   │   │   │   │   │   └── 🐘 CreateOrUpdateReactionListener.php
│   │   │   │   │   ├── 📁 Requests
│   │   │   │   │   │   └── 🐘 VigReactionsRequest.php
│   │   │   │   │   └── 📁 Resources
│   │   │   │   │       └── 🐘 ReactionResource.php
│   │   │   │   ├── 📁 Models
│   │   │   │   │   ├── 🐘 VigReactionMeta.php
│   │   │   │   │   └── 🐘 VigReactions.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   ├── 🐘 EventServiceProvider.php
│   │   │   │   │   ├── 🐘 HookServiceProvider.php
│   │   │   │   │   └── 🐘 VigReactionsServiceProvider.php
│   │   │   │   ├── 📁 Repositories
│   │   │   │   │   ├── 📁 Caches
│   │   │   │   │   │   ├── 🐘 VigReactionMetaCacheDecorator.php
│   │   │   │   │   │   └── 🐘 VigReactionsCacheDecorator.php
│   │   │   │   │   ├── 📁 Eloquent
│   │   │   │   │   │   ├── 🐘 VigReactionMetaRepository.php
│   │   │   │   │   │   └── 🐘 VigReactionsRepository.php
│   │   │   │   │   └── 📁 Interfaces
│   │   │   │   │       ├── 🐘 VigReactionMetaInterface.php
│   │   │   │   │       └── 🐘 VigReactionsInterface.php
│   │   │   │   ├── 📁 Tables
│   │   │   │   │   └── 🐘 VigReactionsTable.php
│   │   │   │   ├── 📁 Traits
│   │   │   │   │   └── 🐘 Reacts.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   ├── 📁 vig-theme-editor
│   │   │   ├── 📁 config
│   │   │   │   ├── 🐘 general.php
│   │   │   │   └── 🐘 permissions.php
│   │   │   ├── 📁 helpers
│   │   │   │   └── 🐘 constants.php
│   │   │   ├── 📁 resources
│   │   │   │   └── 📁 views
│   │   │   │       ├── 📁 editor
│   │   │   │       │   └── 🐘 loop-dir.blade.php
│   │   │   │       ├── ⚙️ .gitkeep
│   │   │   │       ├── 🐘 editor.blade.php
│   │   │   │       └── 🐘 enable.blade.php
│   │   │   ├── 📁 routes
│   │   │   │   └── 🐘 web.php
│   │   │   ├── 📁 src
│   │   │   │   ├── 📁 Http
│   │   │   │   │   └── 📁 Controllers
│   │   │   │   │       └── 🐘 VigThemeEditorController.php
│   │   │   │   ├── 📁 Providers
│   │   │   │   │   └── 🐘 VigThemeEditorServiceProvider.php
│   │   │   │   └── 🐘 Plugin.php
│   │   │   ├── 📝 README.md
│   │   │   └── ⚙️ plugin.json
│   │   └── 📁 wordpress-importer
│   │       ├── 📁 public
│   │       │   └── 📁 js
│   │       │       └── 📄 wordpress-importer.js
│   │       ├── 📁 resources
│   │       │   ├── 📁 js
│   │       │   │   └── 📄 wordpress-importer.js
│   │       │   └── 📁 views
│   │       │       ├── 📁 partials
│   │       │       │   ├── 🐘 category-select.blade.php
│   │       │       │   └── 🐘 woocommerce-products-export-instruction.blade.php
│   │       │       └── 🐘 import.blade.php
│   │       ├── 📁 routes
│   │       │   └── 🐘 web.php
│   │       ├── 📁 src
│   │       │   ├── 📁 Forms
│   │       │   │   └── 🐘 WordpressImporterForm.php
│   │       │   ├── 📁 Http
│   │       │   │   ├── 📁 Controllers
│   │       │   │   │   ├── 🐘 ImportProductController.php
│   │       │   │   │   └── 🐘 WordpressImporterController.php
│   │       │   │   └── 📁 Requests
│   │       │   │       └── 🐘 WordpressImporterRequest.php
│   │       │   ├── 📁 Importers
│   │       │   │   └── 🐘 ProductImporter.php
│   │       │   ├── 📁 Providers
│   │       │   │   └── 🐘 WordpressImporterServiceProvider.php
│   │       │   └── 🐘 WordpressImporter.php
│   │       ├── 📝 README.md
│   │       ├── ⚙️ plugin.json
│   │       └── 📄 webpack.mix.js
│   └── 📁 ui
│       └── 📁 master
│           ├── 📁 assets
│           │   ├── 📁 js
│           │   │   └── 📄 master.js
│           │   └── 📁 sass
│           │       ├── 🎨 _content.scss
│           │       ├── 🎨 _custom.scss
│           │       ├── 🎨 _main.scss
│           │       ├── 🎨 _reset-styles.scss
│           │       ├── 🎨 _rtl.scss
│           │       └── 🎨 style.scss
│           ├── 📁 functions
│           │   ├── 🐘 facebook-integration.php
│           │   ├── 🐘 functions.php
│           │   ├── 🐘 menu-icon-image.php
│           │   ├── 🐘 shortcodes.php
│           │   ├── 🐘 theme-icons-field.php
│           │   └── 🐘 theme-options.php
│           ├── 📁 layouts
│           │   ├── 🐘 default.blade.php
│           │   └── 🐘 no-sidebar.blade.php
│           ├── 📁 partials
│           │   ├── 📁 blog
│           │   │   └── 🐘 post-meta.blade.php
│           │   ├── 📁 shortcodes
│           │   │   ├── 🐘 all-galleries-skeleton.blade.php
│           │   │   ├── 🐘 all-galleries.blade.php
│           │   │   ├── 🐘 featured-categories-posts-skeleton.blade.php
│           │   │   ├── 🐘 featured-categories-posts.blade.php
│           │   │   ├── 🐘 featured-posts-skeleton.blade.php
│           │   │   ├── 🐘 featured-posts.blade.php
│           │   │   ├── 🐘 recent-posts-skeleton.blade.php
│           │   │   └── 🐘 recent-posts.blade.php
│           │   ├── 🐘 breadcrumbs.blade.php
│           │   ├── 🐘 footer.blade.php
│           │   ├── 🐘 header-meta.blade.php
│           │   ├── 🐘 header.blade.php
│           │   ├── 🐘 main-menu.blade.php
│           │   ├── 🐘 search.blade.php
│           │   └── 🐘 sidebar.blade.php
│           ├── 📁 public
│           │   ├── 📁 css
│           │   │   └── 🎨 style.css
│           │   ├── 📁 fonts
│           │   │   ├── 📄 lg.eot
│           │   │   └── 📄 lg.woff
│           │   ├── 📁 images
│           │   │   └── 📁 ui-blocks
│           │   ├── 📁 js
│           │   │   └── 📄 master.js
│           │   └── 📁 plugins
│           │       ├── 📁 bootstrap
│           │       │   └── 📁 css
│           │       └── 📁 jquery
│           ├── 📁 routes
│           │   └── 🐘 web.php
│           ├── 📁 src
│           │   └── 📁 Http
│           │       └── 📁 Controllers
│           │           └── 🐘 MasterController.php
│           ├── 📁 views
│           │   ├── 📁 member
│           │   │   ├── 📁 auth
│           │   │   │   ├── 📁 passwords
│           │   │   │   │   ├── 🐘 email.blade.php
│           │   │   │   │   └── 🐘 reset.blade.php
│           │   │   │   └── 🐘 register.blade.php
│           │   │   └── 🐘 author.blade.php
│           │   ├── 📁 templates
│           │   │   └── 🐘 posts.blade.php
│           │   ├── 🐘 404.blade.php
│           │   ├── 🐘 500.blade.php
│           │   ├── 🐘 503.blade.php
│           │   ├── 🐘 category.blade.php
│           │   ├── 🐘 galleries.blade.php
│           │   ├── 🐘 gallery.blade.php
│           │   ├── 🐘 index.blade.php
│           │   ├── 🐘 loop.blade.php
│           │   ├── 🐘 page.blade.php
│           │   ├── 🐘 post.blade.php
│           │   ├── 🐘 search.blade.php
│           │   └── 🐘 tag.blade.php
│           ├── 📁 widgets
│           │   ├── 📁 blog-categories
│           │   │   ├── 📁 templates
│           │   │   │   └── 🐘 frontend.blade.php
│           │   │   ├── 🐘 blog-categories.php
│           │   │   └── 🐘 registration.php
│           │   ├── 📁 core-simple-menu
│           │   │   └── 📁 templates
│           │   │       └── 🐘 frontend.blade.php
│           │   ├── 📁 custom-menu
│           │   │   ├── 📁 templates
│           │   │   │   └── 🐘 frontend.blade.php
│           │   │   ├── 🐘 custom-menu.php
│           │   │   └── 🐘 registration.php
│           │   ├── 📁 recent-posts
│           │   │   ├── 📁 templates
│           │   │   │   └── 🐘 frontend.blade.php
│           │   │   ├── 🐘 recent-posts.php
│           │   │   └── 🐘 registration.php
│           │   ├── 📁 tags
│           │   │   ├── 📁 templates
│           │   │   │   └── 🐘 frontend.blade.php
│           │   │   ├── 🐘 registration.php
│           │   │   └── 🐘 tags.php
│           │   └── 📁 text
│           │       └── 📁 templates
│           │           └── 🐘 frontend.blade.php
│           ├── 🐘 config.php
│           ├── ⚙️ theme.json
│           └── 📄 webpack.mix.js
├── 📁 dev-extensions
│   ├── 📁 bootstrap
│   │   ├── 📁 config
│   │   │   └── 🐘 general.php
│   │   ├── 📁 database
│   │   │   ├── 📁 migrations
│   │   │   │   └── 🐘 2023_05_21_194154_sample_migration.php
│   │   │   └── 📁 seeders
│   │   ├── 📁 helpers
│   │   │   ├── 🐘 common.php
│   │   │   ├── 🐘 constants.php
│   │   │   └── 🐘 helpers.php
│   │   ├── 📁 public
│   │   │   └── 📁 css
│   │   │       └── 🎨 _social-icons.css
│   │   ├── 📁 resources
│   │   │   ├── 📁 assets
│   │   │   │   └── 📁 sass
│   │   │   │       └── 🎨 _social-icons.scss
│   │   │   ├── 📁 email-templates
│   │   │   │   └── 📄 member-birthday-reminder-notification.tpl
│   │   │   └── 📁 vuexy-mail-template
│   │   │       ├── 📁 images
│   │   │       ├── 🌐 base.html
│   │   │       ├── 🌐 mail-deactivate-account.html
│   │   │       ├── 🌐 mail-invoice.html
│   │   │       ├── 🌐 mail-promotional.html
│   │   │       ├── 🌐 mail-reset-password.html
│   │   │       ├── 🌐 mail-verify-email.html
│   │   │       └── 🌐 mail-welcome.html
│   │   ├── 📁 routes
│   │   │   ├── 🐘 api.php
│   │   │   └── 🐘 web.php
│   │   ├── 📁 src
│   │   │   └── 📁 Providers
│   │   │       └── 🐘 BootstrapServiceProvider.php
│   │   ├── ⚙️ composer.json
│   │   └── 📄 webpack.mix.js
│   └── 📁 libs
│       ├── 📁 advanced-role
│       │   ├── 📁 config
│       │   │   ├── 🐘 advanced-role.php
│       │   │   ├── 🐘 laratrust_seeder.php
│       │   │   ├── 🐘 permissions-seeds.php
│       │   │   └── 🐘 permissions.php
│       │   ├── 📁 database
│       │   │   └── 📁 migrations
│       │   │       ├── 🐘 2023_09_05_233202_create_permission_scopes_tables.php
│       │   │       ├── 🐘 2023_09_07_154908_laratrust_setup_tables.php
│       │   │       └── 🐘 2024_01_11_235039_alter_fields_laratrust_setup_tables.php
│       │   ├── 📁 helpers
│       │   │   └── 🐘 helpers.php
│       │   ├── 📁 resources
│       │   │   └── 📁 views
│       │   │       ├── 📁 emails
│       │   │       │   └── 🐘 invite.blade.php
│       │   │       ├── 🐘 settings-v6.blade.php
│       │   │       └── 🐘 settings.blade.php
│       │   ├── 📁 routes
│       │   │   ├── 🐘 api.php
│       │   │   └── 🐘 web.php
│       │   ├── 📁 src
│       │   │   ├── 📁 Enums
│       │   │   │   ├── 🐘 AgentStatusEnum.php
│       │   │   │   └── 🐘 ScopeEnum.php
│       │   │   ├── 📁 Events
│       │   │   │   ├── 🐘 MemberEvent.php
│       │   │   │   ├── 🐘 RoleEvent.php
│       │   │   │   └── 🐘 TeamEvent.php
│       │   │   ├── 📁 Facades
│       │   │   │   └── 🐘 AdvancedRoleHelper.php
│       │   │   ├── 📁 Http
│       │   │   │   ├── 📁 Controllers
│       │   │   │   │   ├── 📁 API
│       │   │   │   │   │   └── 📁 v1
│       │   │   │   │   │       ├── 🐘 DepartmentController.php
│       │   │   │   │   │       ├── 🐘 PermissionController.php
│       │   │   │   │   │       ├── 🐘 RoleController.php
│       │   │   │   │   │       ├── 🐘 ScopeController.php
│       │   │   │   │   │       └── 🐘 TestController.php
│       │   │   │   │   ├── 🐘 AdvancedRoleController.php
│       │   │   │   │   └── 🐘 MemberController.php
│       │   │   │   ├── 📁 Middleware
│       │   │   │   │   └── 🐘 AdvancedRoleMiddleware.php
│       │   │   │   ├── 📁 Requests
│       │   │   │   │   ├── 📁 v1
│       │   │   │   │   │   ├── 🐘 StoreDepartmentRequest.php
│       │   │   │   │   │   ├── 🐘 StorePermissionRequest.php
│       │   │   │   │   │   ├── 🐘 StoreRoleRequest.php
│       │   │   │   │   │   ├── 🐘 StoreScopeRequest.php
│       │   │   │   │   │   └── 🐘 UpdateScopeRequest.php
│       │   │   │   │   ├── 🐘 AdvancedRoleRequest.php
│       │   │   │   │   └── 🐘 AdvancedRoleSettingRequest.php
│       │   │   │   └── 📁 Resources
│       │   │   │       ├── 🐘 DepartmentListResource.php
│       │   │   │       ├── 🐘 DepartmentResource.php
│       │   │   │       ├── 🐘 PermissionListResource.php
│       │   │   │       ├── 🐘 PermissionResource.php
│       │   │   │       ├── 🐘 RoleListResource.php
│       │   │   │       ├── 🐘 RoleResource.php
│       │   │   │       ├── 🐘 ScopeListResource.php
│       │   │   │       └── 🐘 ScopeResource.php
│       │   │   ├── 📁 Listeners
│       │   │   │   ├── 🐘 DepartmentListener.php
│       │   │   │   ├── 🐘 MemberListener.php
│       │   │   │   └── 🐘 RoleListener.php
│       │   │   ├── 📁 Models
│       │   │   │   ├── 🐘 Department.php
│       │   │   │   ├── 🐘 Member.php
│       │   │   │   ├── 🐘 Permission.php
│       │   │   │   ├── 🐘 PermissionMember.php
│       │   │   │   ├── 🐘 PermissionRole.php
│       │   │   │   ├── 🐘 PersonalAccessToken.php
│       │   │   │   ├── 🐘 Role.php
│       │   │   │   ├── 🐘 RoleMember.php
│       │   │   │   └── 🐘 Scope.php
│       │   │   ├── 📁 Observers
│       │   │   │   ├── 🐘 DepartmentObserver.php
│       │   │   │   ├── 🐘 MemberObserver.php
│       │   │   │   └── 🐘 RoleObserver.php
│       │   │   ├── 📁 Providers
│       │   │   │   ├── 🐘 AdvancedRoleServiceProvider.php
│       │   │   │   ├── 🐘 CommandServiceProvider.php
│       │   │   │   └── 🐘 EventServiceProvider.php
│       │   │   ├── 📁 Repositories
│       │   │   │   ├── 📁 Caches
│       │   │   │   │   ├── 🐘 DepartmentCacheDecorator.php
│       │   │   │   │   ├── 🐘 PermissionCacheDecorator.php
│       │   │   │   │   ├── 🐘 RoleCacheDecorator.php
│       │   │   │   │   └── 🐘 ScopeCacheDecorator.php
│       │   │   │   ├── 📁 Eloquent
│       │   │   │   │   ├── 🐘 DepartmentRepository.php
│       │   │   │   │   ├── 🐘 PermissionRepository.php
│       │   │   │   │   ├── 🐘 RoleRepository.php
│       │   │   │   │   └── 🐘 ScopeRepository.php
│       │   │   │   └── 📁 Interfaces
│       │   │   │       ├── 🐘 DepartmentInterface.php
│       │   │   │       ├── 🐘 PermissionInterface.php
│       │   │   │       ├── 🐘 RoleInterface.php
│       │   │   │       └── 🐘 ScopeInterface.php
│       │   │   ├── 📁 Scopes
│       │   │   │   ├── 📁 Interfaces
│       │   │   │   │   └── 🐘 PermissionsBeforeQueryScope.php
│       │   │   │   └── 🐘 ActiveScope.php
│       │   │   ├── 📁 Seeders
│       │   │   │   ├── 🐘 LaratrustSeeder.php
│       │   │   │   ├── 🐘 PermissionSeeder.php
│       │   │   │   ├── 🐘 RoleSeeder.php
│       │   │   │   └── 🐘 ScopeSeeder.php
│       │   │   ├── 📁 Services
│       │   │   │   └── 🐘 DepartmentService.php
│       │   │   ├── 📁 Supports
│       │   │   │   ├── 🐘 AdvancedRoleHelper.php
│       │   │   │   ├── 🐘 PermissionHelper.php
│       │   │   │   └── 🐘 RoleHelper.php
│       │   │   ├── 📁 Tables
│       │   │   │   └── 🐘 MemberTable.php
│       │   │   └── 📁 Traits
│       │   │       └── 🐘 PermissionQueryBuilderScope.php
│       │   ├── 📄 LICENSE
│       │   ├── 📝 README.md
│       │   └── ⚙️ composer.json
│       ├── 📁 auth
│       │   ├── 📁 config
│       │   │   └── 🐘 permissions.php
│       │   ├── 📁 database
│       │   │   └── 📁 migrations
│       │   │       └── 🐘 2022_08_04_051940_add_missing_column_expires_at.php
│       │   ├── 📁 resources
│       │   │   └── 📁 views
│       │   │       ├── 🐘 settings-v6.blade.php
│       │   │       └── 🐘 settings.blade.php
│       │   ├── 📁 routes
│       │   │   ├── 🐘 api.php
│       │   │   └── 🐘 web.php
│       │   ├── 📁 src
│       │   │   ├── 📁 Facades
│       │   │   │   └── 🐘 AuthHelper.php
│       │   │   ├── 📁 Http
│       │   │   │   ├── 📁 Controllers
│       │   │   │   │   ├── 📁 API
│       │   │   │   │   │   └── 📁 v1
│       │   │   │   │   │       ├── 🐘 AuthController.php
│       │   │   │   │   │       ├── 🐘 ForgotPasswordController.php
│       │   │   │   │   │       ├── 🐘 ProfileController.php
│       │   │   │   │   │       └── 🐘 VerificationController.php
│       │   │   │   │   └── 🐘 AuthController.php
│       │   │   │   ├── 📁 Middleware
│       │   │   │   │   ├── 🐘 RedirectIfMember.php
│       │   │   │   │   └── 🐘 RedirectIfNotMember.php
│       │   │   │   ├── 📁 Requests
│       │   │   │   │   ├── 🐘 AuthRequest.php
│       │   │   │   │   ├── 🐘 AuthSettingRequest.php
│       │   │   │   │   ├── 🐘 ForgotPasswordRequest.php
│       │   │   │   │   ├── 🐘 RegisterRequest.php
│       │   │   │   │   ├── 🐘 ResendEmailVerificationRequest.php
│       │   │   │   │   ├── 🐘 UpdatePasswordRequest.php
│       │   │   │   │   ├── 🐘 UpdateProfileRequest.php
│       │   │   │   │   └── 🐘 VerifyEmailRequest.php
│       │   │   │   └── 📁 Resources
│       │   │   │       └── 🐘 UserResource.php
│       │   │   ├── 📁 Providers
│       │   │   │   └── 🐘 AuthServiceProvider.php
│       │   │   └── 📁 Supports
│       │   │       └── 🐘 AuthHelper.php
│       │   ├── 📄 LICENSE
│       │   ├── 📝 README.md
│       │   └── ⚙️ composer.json
│       ├── 📁 elasticsearch
│       │   ├── 📁 src
│       │   │   ├── 📁 Classes
│       │   │   │   ├── 🐘 Aggregation.php
│       │   │   │   ├── 🐘 Bulk.php
│       │   │   │   ├── 🐘 LikeThis.php
│       │   │   │   └── 🐘 Search.php
│       │   │   ├── 📁 Commands
│       │   │   │   ├── 🐘 CreateIndexCommand.php
│       │   │   │   ├── 🐘 DropIndexCommand.php
│       │   │   │   ├── 🐘 ListIndicesCommand.php
│       │   │   │   ├── 🐘 ReindexCommand.php
│       │   │   │   └── 🐘 UpdateIndexCommand.php
│       │   │   ├── 📁 Facades
│       │   │   │   └── 🐘 ES.php
│       │   │   ├── 📁 config
│       │   │   │   ├── 🐘 es.php
│       │   │   │   └── 🐘 scout.php
│       │   │   ├── 📁 pagination
│       │   │   │   ├── 🐘 bootstrap-4.php
│       │   │   │   ├── 🐘 default.php
│       │   │   │   ├── 🐘 simple-bootstrap-4.php
│       │   │   │   └── 🐘 simple-default.php
│       │   │   ├── 🐘 Collection.php
│       │   │   ├── 🐘 Connection.php
│       │   │   ├── 🐘 ElasticsearchServiceProvider.php
│       │   │   ├── 🐘 Index.php
│       │   │   ├── 🐘 Model.php
│       │   │   ├── 🐘 Pagination.php
│       │   │   ├── 🐘 Query.php
│       │   │   ├── 🐘 Request.php
│       │   │   ├── 🐘 ScoutEngine.php
│       │   │   └── 🐘 helpers.php
│       │   ├── 📁 tests
│       │   │   ├── 📁 Traits
│       │   │   │   └── 🐘 ESQueryTrait.php
│       │   │   ├── 🐘 BodyTest.php
│       │   │   ├── 🐘 DistanceTest.php
│       │   │   ├── 🐘 IgnoreTest.php
│       │   │   ├── 🐘 IndexTest.php
│       │   │   ├── 🐘 OrderTest.php
│       │   │   ├── 🐘 SearchTest.php
│       │   │   ├── 🐘 SelectTest.php
│       │   │   ├── 🐘 SkipTest.php
│       │   │   ├── 🐘 TakeTest.php
│       │   │   ├── 🐘 TypeTest.php
│       │   │   ├── 🐘 WhereBetweenTest.php
│       │   │   ├── 🐘 WhereInTest.php
│       │   │   ├── 🐘 WhereNotBetweenTest.php
│       │   │   ├── 🐘 WhereNotInTest.php
│       │   │   ├── 🐘 WhereNotTest.php
│       │   │   └── 🐘 WhereTest.php
│       │   ├── ⚙️ .editorconfig
│       │   ├── ⚙️ .gitignore
│       │   ├── ⚙️ .travis.yml
│       │   ├── 📝 CHANGELOG.md
│       │   ├── 📄 LICENSE
│       │   ├── ⚙️ _config.yml
│       │   ├── ⚙️ composer.json
│       │   ├── ⚙️ phpunit.xml
│       │   └── 📝 readme.md
│       ├── 📁 elasticsearch-laravel
│       │   ├── 📁 config
│       │   │   ├── 🐘 es.php
│       │   │   └── 🐘 general.php
│       │   ├── 📁 helpers
│       │   │   └── 🐘 helpers.php
│       │   ├── 📁 routes
│       │   │   └── 🐘 api.php
│       │   ├── 📁 src
│       │   │   ├── 📁 Commands
│       │   │   │   └── 🐘 ElasticSearchMakeIndex.php
│       │   │   ├── 📁 Facades
│       │   │   │   └── 🐘 ElasticsearchLaravelFacade.php
│       │   │   ├── 📁 Http
│       │   │   │   └── 📁 Controllers
│       │   │   │       └── 📁 API
│       │   │   │           └── 🐘 SearchController.php
│       │   │   ├── 📁 Jobs
│       │   │   │   ├── 🐘 EsMakeindexJob.php
│       │   │   │   └── 🐘 EsMakeindexSingleJob.php
│       │   │   ├── 📁 Providers
│       │   │   │   ├── 🐘 CommandServiceProvider.php
│       │   │   │   └── 🐘 ElasticsearchLaravelServiceProvider.php
│       │   │   ├── 📁 Repositories
│       │   │   │   ├── 📁 Caches
│       │   │   │   │   └── 🐘 PostCacheDecorator.php
│       │   │   │   ├── 📁 Eloquent
│       │   │   │   │   └── 🐘 PostRepository.php
│       │   │   │   └── 📁 Interfaces
│       │   │   │       └── 🐘 PostInterface.php
│       │   │   └── 📁 Services
│       │   │       ├── 🐘 BlogService.php
│       │   │       └── 🐘 ElasticsearchService.php
│       │   ├── ⚙️ composer.json
│       │   └── 📝 readme.md
│       ├── 📁 img-optimize-laravel
│       │   ├── 📁 database
│       │   │   └── 📁 migrations
│       │   │       └── 🐘 2024_07_18_162425_alter_fields_on_table_media.php
│       │   ├── 📁 helpers
│       │   │   └── 🐘 helpers.php
│       │   ├── 📁 src
│       │   │   ├── 📁 Commands
│       │   │   │   └── 🐘 WebPCommand.php
│       │   │   └── 📁 Providers
│       │   │       ├── 🐘 CommandServiceProvider.php
│       │   │       ├── 🐘 EventServiceProvider.php
│       │   │       └── 🐘 ImgOptimizeServiceProvider.php
│       │   ├── 📝 README.md
│       │   └── ⚙️ composer.json
│       ├── 📁 laravel-migrations-generator
│       │   ├── 📁 config
│       │   │   └── 🐘 migrations-generator.php
│       │   ├── 📁 src
│       │   │   ├── 📁 Database
│       │   │   │   ├── 📁 Models
│       │   │   │   │   ├── 📁 MySQL
│       │   │   │   │   │   ├── 🐘 MySQLColumn.php
│       │   │   │   │   │   ├── 🐘 MySQLColumnType.php
│       │   │   │   │   │   ├── 🐘 MySQLForeignKey.php
│       │   │   │   │   │   ├── 🐘 MySQLIndex.php
│       │   │   │   │   │   ├── 🐘 MySQLProcedure.php
│       │   │   │   │   │   ├── 🐘 MySQLTable.php
│       │   │   │   │   │   ├── 🐘 MySQLUDTColumn.php
│       │   │   │   │   │   └── 🐘 MySQLView.php
│       │   │   │   │   ├── 📁 PgSQL
│       │   │   │   │   │   ├── 🐘 PgSQLColumn.php
│       │   │   │   │   │   ├── 🐘 PgSQLColumnType.php
│       │   │   │   │   │   ├── 🐘 PgSQLForeignKey.php
│       │   │   │   │   │   ├── 🐘 PgSQLIndex.php
│       │   │   │   │   │   ├── 🐘 PgSQLParser.php
│       │   │   │   │   │   ├── 🐘 PgSQLProcedure.php
│       │   │   │   │   │   ├── 🐘 PgSQLTable.php
│       │   │   │   │   │   ├── 🐘 PgSQLUDTColumn.php
│       │   │   │   │   │   └── 🐘 PgSQLView.php
│       │   │   │   │   ├── 📁 SQLSrv
│       │   │   │   │   │   ├── 🐘 SQLSrvColumn.php
│       │   │   │   │   │   ├── 🐘 SQLSrvColumnType.php
│       │   │   │   │   │   ├── 🐘 SQLSrvForeignKey.php
│       │   │   │   │   │   ├── 🐘 SQLSrvIndex.php
│       │   │   │   │   │   ├── 🐘 SQLSrvParser.php
│       │   │   │   │   │   ├── 🐘 SQLSrvProcedure.php
│       │   │   │   │   │   ├── 🐘 SQLSrvTable.php
│       │   │   │   │   │   ├── 🐘 SQLSrvUDTColumn.php
│       │   │   │   │   │   └── 🐘 SQLSrvView.php
│       │   │   │   │   ├── 📁 SQLite
│       │   │   │   │   │   ├── 🐘 SQLiteColumn.php
│       │   │   │   │   │   ├── 🐘 SQLiteColumnType.php
│       │   │   │   │   │   ├── 🐘 SQLiteForeignKey.php
│       │   │   │   │   │   ├── 🐘 SQLiteIndex.php
│       │   │   │   │   │   ├── 🐘 SQLiteTable.php
│       │   │   │   │   │   ├── 🐘 SQLiteUDTColumn.php
│       │   │   │   │   │   └── 🐘 SQLiteView.php
│       │   │   │   │   ├── 🐘 Blueprint.php
│       │   │   │   │   ├── 🐘 DatabaseColumn.php
│       │   │   │   │   ├── 🐘 DatabaseForeignKey.php
│       │   │   │   │   ├── 🐘 DatabaseIndex.php
│       │   │   │   │   ├── 🐘 DatabaseProcedure.php
│       │   │   │   │   ├── 🐘 DatabaseTable.php
│       │   │   │   │   ├── 🐘 DatabaseUDTColumn.php
│       │   │   │   │   └── 🐘 DatabaseView.php
│       │   │   │   ├── 🐘 DatabaseColumnType.php
│       │   │   │   ├── 🐘 DatabaseSchema.php
│       │   │   │   ├── 🐘 MySQLSchema.php
│       │   │   │   ├── 🐘 PgSQLSchema.php
│       │   │   │   ├── 🐘 SQLSrvSchema.php
│       │   │   │   └── 🐘 SQLiteSchema.php
│       │   │   ├── 📁 Enum
│       │   │   │   ├── 📁 Migrations
│       │   │   │   │   ├── 📁 Method
│       │   │   │   │   │   ├── 🐘 ColumnModifier.php
│       │   │   │   │   │   ├── 🐘 ColumnType.php
│       │   │   │   │   │   ├── 🐘 DBBuilder.php
│       │   │   │   │   │   ├── 🐘 Foreign.php
│       │   │   │   │   │   ├── 🐘 IndexType.php
│       │   │   │   │   │   ├── 🐘 MethodName.php
│       │   │   │   │   │   ├── 🐘 SchemaBuilder.php
│       │   │   │   │   │   └── 🐘 TableMethod.php
│       │   │   │   │   ├── 📁 Property
│       │   │   │   │   │   ├── 🐘 PropertyName.php
│       │   │   │   │   │   └── 🐘 TableProperty.php
│       │   │   │   │   └── 🐘 ColumnName.php
│       │   │   │   └── 🐘 Driver.php
│       │   │   ├── 📁 Migration
│       │   │   │   ├── 📁 Blueprint
│       │   │   │   │   ├── 📁 Support
│       │   │   │   │   │   ├── 🐘 MergeTimestamps.php
│       │   │   │   │   │   ├── 🐘 MethodStringHelper.php
│       │   │   │   │   │   └── 🐘 Stringable.php
│       │   │   │   │   ├── 🐘 DBStatementBlueprint.php
│       │   │   │   │   ├── 🐘 DBUnpreparedBlueprint.php
│       │   │   │   │   ├── 🐘 Method.php
│       │   │   │   │   ├── 🐘 Property.php
│       │   │   │   │   ├── 🐘 SchemaBlueprint.php
│       │   │   │   │   ├── 🐘 TableBlueprint.php
│       │   │   │   │   └── 🐘 WritableBlueprint.php
│       │   │   │   ├── 📁 Enum
│       │   │   │   │   ├── 🐘 MigrationFileType.php
│       │   │   │   │   └── 🐘 Space.php
│       │   │   │   ├── 📁 Generator
│       │   │   │   │   ├── 📁 Columns
│       │   │   │   │   │   ├── 🐘 BooleanColumn.php
│       │   │   │   │   │   ├── 🐘 ColumnTypeGenerator.php
│       │   │   │   │   │   ├── 🐘 DatetimeColumn.php
│       │   │   │   │   │   ├── 🐘 DecimalColumn.php
│       │   │   │   │   │   ├── 🐘 DoubleColumn.php
│       │   │   │   │   │   ├── 🐘 FloatColumn.php
│       │   │   │   │   │   ├── 🐘 IntegerColumn.php
│       │   │   │   │   │   ├── 🐘 MiscColumn.php
│       │   │   │   │   │   ├── 🐘 OmitNameColumn.php
│       │   │   │   │   │   ├── 🐘 PresetValuesColumn.php
│       │   │   │   │   │   ├── 🐘 SoftDeleteColumn.php
│       │   │   │   │   │   ├── 🐘 SpatialColumn.php
│       │   │   │   │   │   └── 🐘 StringColumn.php
│       │   │   │   │   ├── 📁 Modifiers
│       │   │   │   │   │   ├── 🐘 CharsetModifier.php
│       │   │   │   │   │   ├── 🐘 CollationModifier.php
│       │   │   │   │   │   ├── 🐘 CommentModifier.php
│       │   │   │   │   │   ├── 🐘 DefaultModifier.php
│       │   │   │   │   │   ├── 🐘 IndexModifier.php
│       │   │   │   │   │   ├── 🐘 Modifier.php
│       │   │   │   │   │   ├── 🐘 NullableModifier.php
│       │   │   │   │   │   ├── 🐘 StoredAsModifier.php
│       │   │   │   │   │   └── 🐘 VirtualAsModifier.php
│       │   │   │   │   ├── 🐘 ColumnGenerator.php
│       │   │   │   │   ├── 🐘 ForeignKeyGenerator.php
│       │   │   │   │   └── 🐘 IndexGenerator.php
│       │   │   │   ├── 📁 Migrator
│       │   │   │   │   └── 🐘 Migrator.php
│       │   │   │   ├── 📁 Writer
│       │   │   │   │   ├── 🐘 MigrationStub.php
│       │   │   │   │   ├── 🐘 MigrationWriter.php
│       │   │   │   │   └── 🐘 SquashWriter.php
│       │   │   │   ├── 🐘 ForeignKeyMigration.php
│       │   │   │   ├── 🐘 ProcedureMigration.php
│       │   │   │   ├── 🐘 Squash.php
│       │   │   │   ├── 🐘 TableMigration.php
│       │   │   │   └── 🐘 ViewMigration.php
│       │   │   ├── 📁 Repositories
│       │   │   │   ├── 📁 Entities
│       │   │   │   │   ├── 📁 MariaDB
│       │   │   │   │   │   └── 🐘 CheckConstraint.php
│       │   │   │   │   ├── 📁 MySQL
│       │   │   │   │   │   └── 🐘 ShowColumn.php
│       │   │   │   │   ├── 📁 PgSQL
│       │   │   │   │   │   └── 🐘 IndexDefinition.php
│       │   │   │   │   ├── 📁 SQLSrv
│       │   │   │   │   │   └── 🐘 ColumnDefinition.php
│       │   │   │   │   └── 🐘 ProcedureDefinition.php
│       │   │   │   ├── 🐘 MariaDBRepository.php
│       │   │   │   ├── 🐘 MySQLRepository.php
│       │   │   │   ├── 🐘 PgSQLRepository.php
│       │   │   │   ├── 🐘 Repository.php
│       │   │   │   ├── 🐘 SQLSrvRepository.php
│       │   │   │   └── 🐘 SQLiteRepository.php
│       │   │   ├── 📁 Schema
│       │   │   │   ├── 📁 Models
│       │   │   │   │   ├── 🐘 Column.php
│       │   │   │   │   ├── 🐘 ForeignKey.php
│       │   │   │   │   ├── 🐘 Index.php
│       │   │   │   │   ├── 🐘 Model.php
│       │   │   │   │   ├── 🐘 Procedure.php
│       │   │   │   │   ├── 🐘 Table.php
│       │   │   │   │   ├── 🐘 UDTColumn.php
│       │   │   │   │   └── 🐘 View.php
│       │   │   │   ├── 🐘 MySQLSchema.php
│       │   │   │   ├── 🐘 PgSQLSchema.php
│       │   │   │   ├── 🐘 SQLSrvSchema.php
│       │   │   │   ├── 🐘 SQLiteSchema.php
│       │   │   │   └── 🐘 Schema.php
│       │   │   ├── 📁 Support
│       │   │   │   ├── 🐘 AssetNameQuote.php
│       │   │   │   ├── 🐘 CheckLaravelVersion.php
│       │   │   │   ├── 🐘 IndexNameHelper.php
│       │   │   │   ├── 🐘 MigrationNameHelper.php
│       │   │   │   ├── 🐘 Regex.php
│       │   │   │   └── 🐘 TableName.php
│       │   │   ├── 🐘 MigrateGenerateCommand.php
│       │   │   ├── 🐘 MigrationsGeneratorServiceProvider.php
│       │   │   └── 🐘 Setting.php
│       │   ├── 📁 stubs
│       │   │   └── 📄 migration.generate.stub
│       │   ├── 📄 LICENSE
│       │   ├── 📝 README.md
│       │   └── ⚙️ composer.json
│       ├── 📁 onesignal
│       │   ├── 📁 src
│       │   │   ├── 📁 Exceptions
│       │   │   │   └── 🐘 CouldNotSendNotification.php
│       │   │   ├── 🐘 Onesignal.php
│       │   │   ├── 🐘 OnesignalChannel.php
│       │   │   ├── 🐘 OnesignalMessage.php
│       │   │   └── 🐘 OnesignalServiceProvider.php
│       │   ├── ⚙️ .editorconfig
│       │   ├── 📝 CHANGELOG.md
│       │   ├── 📝 CONTRIBUTING.md
│       │   ├── 📝 LICENSE.md
│       │   └── ⚙️ composer.json
│       └── 📁 onesignal-channel
│           ├── 📁 src
│           │   ├── 📁 Channels
│           │   │   ├── 🐘 OneSignalBaseClient.php
│           │   │   └── 🐘 OneSignalChannel.php
│           │   ├── 📁 Messages
│           │   │   └── 🐘 OnesignalMessage.php
│           │   └── 🐘 OneSignalChannelServiceProvider.php
│           └── ⚙️ composer.json
├── 📁 docker
│   ├── ⚙️ .gitignore
│   └── 📝 README.MD
├── 📁 docker-example
│   ├── 📁 cron
│   │   └── 📄 www-data
│   ├── 📁 elasticsearch-analysis-vietnamese
│   │   ├── 📁 config
│   │   │   ├── 📁 jvm.options.d
│   │   │   │   └── 📄 heap.options
│   │   │   ├── ⚙️ elasticsearch-plugins.example.yml
│   │   │   ├── 📄 elasticsearch.keystore
│   │   │   ├── ⚙️ elasticsearch.yml
│   │   │   ├── 📄 jvm.options
│   │   │   ├── ⚙️ role_mapping.yml
│   │   │   ├── ⚙️ roles.yml
│   │   │   ├── 📄 users
│   │   │   └── 📄 users_roles
│   │   ├── 📁 src
│   │   │   ├── 📁 main
│   │   │   │   ├── 📁 assemblies
│   │   │   │   │   └── ⚙️ plugin.xml
│   │   │   │   ├── 📁 java
│   │   │   │   │   ├── 📁 com
│   │   │   │   │   │   └── 📁 coccoc
│   │   │   │   │   │       ├── ☕ Token.java
│   │   │   │   │   │       ├── ☕ Tokenizer.java
│   │   │   │   │   │       └── ☕ Unsafe.java
│   │   │   │   │   └── 📁 org
│   │   │   │   │       ├── 📁 apache
│   │   │   │   │       │   └── 📁 lucene
│   │   │   │   │       │       └── 📁 analysis
│   │   │   │   │       │           └── 📁 vi
│   │   │   │   │       └── 📁 elasticsearch
│   │   │   │   │           ├── 📁 analysis
│   │   │   │   │           │   └── ☕ VietnameseConfig.java
│   │   │   │   │           ├── 📁 index
│   │   │   │   │           │   └── 📁 analysis
│   │   │   │   │           │       ├── ☕ VietnameseAnalyzerProvider.java
│   │   │   │   │           │       ├── ☕ VietnameseStopTokenFilterFactory.java
│   │   │   │   │           │       └── ☕ VietnameseTokenizerFactory.java
│   │   │   │   │           └── 📁 plugin
│   │   │   │   │               └── 📁 analysis
│   │   │   │   │                   └── 📁 vi
│   │   │   │   └── 📁 resources
│   │   │   │       ├── 📁 org
│   │   │   │       │   └── 📁 apache
│   │   │   │       │       └── 📁 lucene
│   │   │   │       │           └── 📁 analysis
│   │   │   │       │               └── 📁 vi
│   │   │   │       ├── 📄 es-plugin.properties
│   │   │   │       ├── 📄 plugin-descriptor.properties
│   │   │   │       └── 📄 plugin-security.policy
│   │   │   └── 📁 test
│   │   │       ├── 📁 java
│   │   │       │   └── 📁 org
│   │   │       │       └── 📁 elasticsearch
│   │   │       │           └── 📁 index
│   │   │       │               └── 📁 analysis
│   │   │       │                   ├── ☕ VietnameseAnalysisIntegrationTests.java
│   │   │       │                   └── ☕ VietnameseAnalysisTests.java
│   │   │       └── 📁 resources
│   │   │           └── 📁 org
│   │   │               └── 📁 elasticsearch
│   │   │                   └── 📁 index
│   │   │                       └── 📁 analysis
│   │   │                           └── ⚙️ vi_analysis.json
│   │   ├── ⚙️ .env.sample
│   │   ├── 🐳 Dockerfile
│   │   ├── 📄 LICENSE.txt
│   │   ├── 📝 README.md
│   │   ├── ⚙️ docker-compose.yaml
│   │   └── ⚙️ pom.xml
│   ├── 📁 mongodb-psm.sharp
│   │   ├── 📁 config
│   │   │   └── ⚙️ mongod.conf
│   │   ├── ⚙️ docker-compose.yml
│   │   └── 📄 mongo-init.js
│   ├── 📁 mqtt
│   │   ├── ⚙️ .gitignore
│   │   ├── 🐳 Dockerfile
│   │   ├── 📄 LICENSE
│   │   ├── 📄 Makefile
│   │   ├── 📝 README.md
│   │   ├── 📄 docker-compose.override.yml.dist
│   │   └── ⚙️ docker-compose.yaml
│   ├── 📁 mysql
│   │   └── 📁 etc
│   │       ├── 📁 conf.d
│   │       │   ├── ⚙️ docker.conf
│   │       │   └── ⚙️ mysql.conf
│   │       ├── 📄 my.cnf
│   │       ├── 📄 my.cnf.fallback
│   │       └── 📄 my.cnf.optimize
│   ├── 📁 nginx
│   │   ├── 🐳 Dockerfile
│   │   └── ⚙️ default.conf
│   ├── 📁 nuxtjs-client-vs-server
│   │   ├── 📁 client
│   │   │   └── 🐳 Dockerfile
│   │   ├── 📁 nginx
│   │   │   ├── 🐳 Dockerfile
│   │   │   └── ⚙️ default.conf
│   │   ├── 📁 php
│   │   │   ├── 🐳 Dockerfile
│   │   │   └── ⚙️ php.ini
│   │   ├── 📄 Makefile
│   │   └── ⚙️ docker-compose.yml
│   ├── 📁 php
│   │   ├── 🐳 Dockerfile
│   │   └── ⚙️ php.ini
│   ├── 📁 postgresql
│   │   ├── 📁 init
│   │   │   └── 📄 dbinit_pnjp.sql
│   │   ├── 🐳 Dockerfile
│   │   └── ⚙️ docker-compose.yml
│   └── 📁 redis
│       ├── 📁 conf
│       │   └── ⚙️ redis.conf
│       └── ⚙️ docker-compose.yml
├── 📁 public
│   ├── ⚙️ .htaccess
│   ├── 🎵 bgm.mp3
│   ├── 🌐 cataract-prediction.html
│   ├── 🎵 click.mp3
│   ├── 🌐 facebook-sharing.html
│   ├── 🌐 facebook-sharing_toan.html
│   ├── 📄 favicon.ico
│   ├── 🌐 form-test.html
│   ├── 🌐 game-piano-tiles.html
│   ├── 🐘 index.php
│   ├── 📄 robots.txt
│   └── ⚙️ web.config
├── 📁 resources
│   ├── 📁 js
│   │   ├── 📄 app.js
│   │   └── 📄 bootstrap.js
│   └── 📁 views
│       └── ⚙️ .gitkeep
├── 📁 routes
│   ├── 🐘 console.php
│   └── 🐘 web.php
├── 📁 scripts
│   └── 📄 don_vi_hanh_chinh_2025.xlsx
├── 📁 storage
│   ├── 📁 app
│   │   ├── 📁 purifier
│   │   │   └── 📁 HTML
│   │   └── ⚙️ .gitignore
│   ├── 📁 debugbar
│   │   └── ⚙️ .gitignore
│   └── 📁 framework
│       ├── 📁 sessions
│       ├── 📁 testing
│       ├── 📁 views
│       └── ⚙️ .gitignore
├── 📁 stubs
│   ├── 📄 export.model.stub
│   ├── 📄 export.plain.stub
│   ├── 📄 export.query-model.stub
│   ├── 📄 export.query.stub
│   ├── 📄 import.collection.stub
│   └── 📄 import.model.stub
├── 📁 tests
│   ├── 📁 Feature
│   │   └── 🐘 ExampleTest.php
│   ├── 📁 Unit
│   │   └── 🐘 ExampleTest.php
│   └── 🐘 TestCase.php
├── ⚙️ .editorconfig
├── ⚙️ .env.example
├── ⚙️ .gitattributes
├── ⚙️ .gitignore
├── ⚙️ .gitlab-ci.yml-template.yml
├── ⚙️ .htaccess
├── ⚙️ .rnd
├── 🐳 Dockerfile
├── 📄 Makefile
├── 📝 README.md
├── 📄 artisan
├── ⚙️ composer.json
├── 📄 composer.phar
├── 📄 database.sql
├── ⚙️ docker-compose.yml
├── 📄 favicon.ico
├── 📄 laravel-echo-server.json-sample
├── ⚙️ laravel-queue-worker.yml
├── 📄 laravel.ico
├── ⚙️ package-lock.json
├── ⚙️ package.json
├── ⚙️ phpunit.xml
├── 📄 pm2.json-sample
├── 📄 sail
├── 🐘 server.php
└── 📄 webpack.mix.js
```

---
*Generated by FileTree Pro Extension*