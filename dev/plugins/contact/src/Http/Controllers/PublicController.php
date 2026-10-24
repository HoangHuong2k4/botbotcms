<?php

namespace Dev\Contact\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Contact\Http\Requests\ContactRequest;
use Dev\Contact\Http\Requests\CreateContactRequest;
use Dev\Contact\Enums\ContactStatusEnum;
use Dev\Contact\Services\ContactService;
use Illuminate\Validation\ValidationException;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Contact\Events\SentContactEvent;
use Dev\Contact\Models\Contact;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dev\Base\Rules\EmailRule;
use Dev\Base\Rules\PhoneNumberRule;

class PublicController extends BaseController
{
    public function __construct(protected ContactService $contactService)
    {
    }

    public function postSendContact(ContactRequest $request)
    {
        try {
            $result = $this->contactService->sendContact($request);

            if (! $result['success']) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage($result['message']);
            }

            return $this
                ->httpResponse()
                ->setMessage($result['message']);
        } catch (ValidationException $exception) {
            throw $exception;
        }
    }
    
    public function postCreateContact(CreateContactRequest $request, BaseHttpResponse $response)
    {
      try {
          DB::beginTransaction();

          // Lọc và chỉ lấy các custom fields có giá trị
          $customFields = array_filter([
              'visitModelHouse' => $request->validated('visitModelHouse'),
              'deepConsultation' => $request->validated('deepConsultation'),
          ]);

          // Dữ liệu contact
          $contactData = [
              'name'    => $request->validated('name'),
              'email'   => $request->validated('email'),
              'phone'   => $request->validated('phone'),
              'gender'  => $request->validated('gender'),
              'content' => $request->validated('content') ?? 'Liên hệ từ form trang contact',
          ];

          // Chỉ thêm custom_fields nếu có giá trị
          if (! empty($customFields)) {
              $contactData['custom_fields'] = json_encode($customFields);
          }

          // Tạo contact
          $contact = Contact::create($contactData);

          // Gửi event
          event(new SentContactEvent($contact));

          DB::commit();

          return response()->json([
              'type'    => 'success',
              'message' => 'Gửi thông tin thành công!',
          ]);

      } catch (Exception $exception) {
          DB::rollBack();
          Log::error('Lỗi tạo contact: ' . $exception->getMessage());
          Log::error('Stack trace: ' . $exception->getTraceAsString());

          return response()->json([
              'type'    => 'error',
              'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.',
          ], 500);
      }
    }

    public function postFooterSubscribe(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate email
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:60'],
            ], [
                'email.required' => 'Vui lòng nhập địa chỉ email.',
                'email.email'    => 'Địa chỉ email không hợp lệ.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type'    => 'error',
                    'message' => 'Lỗi: ' . $validator->errors()->first()
                ], 422);
            }

            $email = $request->input('email');
            // Lấy name từ phần trước @ của email
            $name = explode('@', $email)[0] ?? $email;
            $name = ucfirst($name); // Viết hoa chữ cái đầu
            $content = 'Đăng ký nhận thông tin khuyến mãi';

            // Lưu vào bảng contacts
            $contact = Contact::create([
                'name'    => $name,
                'email'   => $email,
                'phone'   => null,
                'content' => $content,
                'subject' => 'Đăng ký nhận thông tin khuyến mãi',
                'status'  => ContactStatusEnum::UNREAD(),
            ]);

            // Gửi event sau khi response trả về để không bắt KH đợi gửi Mail
            app()->terminating(function () use ($contact) {
                event(new SentContactEvent($contact));
            });

            DB::commit();

            return response()->json([
                'type'    => 'success',
                'message' => 'Đăng ký nhận thông tin thành công!',
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Lỗi tạo contact (Footer Subscribe): ' . $exception->getMessage());
            Log::error('Stack trace: ' . $exception->getTraceAsString());

            return response()->json([
                'type'    => 'error',
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.',
            ], 500);
        }
    }
}
