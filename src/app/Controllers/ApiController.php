<?php

abstract class ApiController extends Controller {
    protected function handle(callable $callback): void {
        try {
            $callback();
        } catch (InvalidArgumentException $exception) {
            ResponseHelper::error($exception->getMessage(), 400);
        } catch (RuntimeException $exception) {
            ResponseHelper::error($exception->getMessage(), 400);
        } catch (Throwable $exception) {
            ResponseHelper::error('Internal server error', 500);
        }
    }
}
