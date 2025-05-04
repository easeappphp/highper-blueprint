<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use EaseAppPHP\HighPer\Framework\API\ApiController;
use OpenTelemetry\API\Trace\SpanKind;

class UserController extends ApiController
{
    /**
     * Get all users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        // Create a span for tracing
        $span = $this->tracer->spanBuilder('UserController.index')
            ->setSpanKind(SpanKind::KIND_SERVER)
            ->startSpan();
        
        try {
            // Get query parameters
            $page = (int) ($request->getQueryParameter('page') ?? 1);
            $perPage = (int) ($request->getQueryParameter('per_page') ?? 15);
            
            // Get the user model
            $userModel = $this->container->get('App\\Models\\UserModel');
            
            // Get all users
            $users = $userModel->all([
                'page' => $page,
                'per_page' => $perPage,
            ]);
            
            // Get total count
            $total = $userModel->count();
            
            // Return paginated response
            return $this->paginate($users, $total, $page, $perPage);
        } catch (\Throwable $e) {
            // Log the error
            $this->logger->error('Error getting users', [
                'exception' => $e,
            ]);
            
            // Record the exception in the span
            $span->recordException($e);
            
            // Return error response
            return $this->error('Error getting users', null, 500);
        } finally {
            // End the span
            $span->end();
        }
    }

    /**
     * Create a new user
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        // Create a span for tracing
        $span = $this->tracer->spanBuilder('UserController.store')
            ->setSpanKind(SpanKind::KIND_SERVER)
            ->startSpan();
        
        try {
            // Get request body
            $data = $this->getJsonData($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);
            
            // If validation failed, return the error response
            if ($data instanceof Response) {
                return $data;
            }
            
            // Get the user model
            $userModel = $this->container->get('App\\Models\\UserModel');
            
            // Create the user
            $user = $userModel->create($data);
            
            // Return created response
            return $this->created($user, "/api/v1/users/{$user['id']}");
        } catch (\Throwable $e) {
            // Log the error
            $this->logger->error('Error creating user', [
                'exception' => $e,
            ]);
            
            // Record the exception in the span
            $span->recordException($e);
            
            // Return error response
            return $this->error('Error creating user', null, 500);
        } finally {
            // End the span
            $span->end();
        }
    }

    /**
     * Get a user by ID
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        // Create a span for tracing
        $span = $this->tracer->spanBuilder('UserController.show')
            ->setSpanKind(SpanKind::KIND_SERVER)
            ->startSpan();
        
        try {
            // Get the user ID from the route parameters
            $id = $this->getParam($request, 'id');
            
            // Get the user model
            $userModel = $this->container->get('App\\Models\\UserModel');
            
            // Find the user
            $user = $userModel->find($id);
            
            // If user not found, return 404
            if (!$user) {
                return $this->notFound('User not found');
            }
            
            // Return the user
            return $this->success($user);
        } catch (\Throwable $e) {
            // Log the error
            $this->logger->error('Error getting user', [
                'exception' => $e,
                'id' => $id ?? null,
            ]);
            
            // Record the exception in the span
            $span->recordException($e);
            
            // Return error response
            return $this->error('Error getting user', null, 500);
        } finally {
            // End the span
            $span->end();
        }
    }

    /**
     * Update a user
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        // Create a span for tracing
        $span = $this->tracer->spanBuilder('UserController.update')
            ->setSpanKind(SpanKind::KIND_SERVER)
            ->startSpan();
        
        try {
            // Get the user ID from the route parameters
            $id = $this->getParam($request, 'id');
            
            // Get request body
            $data = $this->getJsonData($request, [
                'name' => 'string|max:255',
                'email' => "email|unique:users,email,{$id}",
                'password' => 'string|min:8',
            ]);
            
            // If validation failed, return the error response
            if ($data instanceof Response) {
                return $data;
            }
            
            // Get the user model
            $userModel = $this->container->get('App\\Models\\UserModel');
            
            // Find the user
            $user = $userModel->find($id);
            
            // If user not found, return 404
            if (!$user) {
                return $this->notFound('User not found');
            }
            
            // Update the user
            $success = $userModel->update($id, $data);
            
            // If update failed, return error
            if (!$success) {
                return $this->error('Error updating user');
            }
            
            // Get the updated user
            $user = $userModel->find($id);
            
            // Return the updated user
            return $this->success($user);
        } catch (\Throwable $e) {
            // Log the error
            $this->logger->error('Error updating user', [
                'exception' => $e,
                'id' => $id ?? null,
            ]);
            
            // Record the exception in the span
            $span->recordException($e);
            
            // Return error response
            return $this->error('Error updating user', null, 500);
        } finally {
            // End the span
            $span->end();
        }
    }

    /**
     * Delete a user
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request): Response
    {
        // Create a span for tracing
        $span = $this->tracer->spanBuilder('UserController.destroy')
            ->setSpanKind(SpanKind::KIND_SERVER)
            ->startSpan();
        
        try {
            // Get the user ID from the route parameters
            $id = $this->getParam($request, 'id');
            
            // Get the user model
            $userModel = $this->container->get('App\\Models\\UserModel');
            
            // Find the user
            $user = $userModel->find($id);
            
            // If user not found, return 404
            if (!$user) {
                return $this->notFound('User not found');
            }
            
            // Delete the user
            $success = $userModel->delete($id);
            
            // If delete failed, return error
            if (!$success) {
                return $this->error('Error deleting user');
            }
            
            // Return no content response
            return $this->noContent();
        } catch (\Throwable $e) {
            // Log the error
            $this->logger->error('Error deleting user', [
                'exception' => $e,
                'id' => $id ?? null,
            ]);
            
            // Record the exception in the span
            $span->recordException($e);
            
            // Return error response
            return $this->error('Error deleting user', null, 500);
        } finally {
            // End the span
            $span->end();
        }
    }
}