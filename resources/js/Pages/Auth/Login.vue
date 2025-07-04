<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="تسجيل الدخول" />

    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-yellow-100 via-green-100 to-white">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 border-t-8 border-green-400">
            <div class="flex flex-col items-center mb-6">
                <AuthenticationCardLogo />
                <h1 class="mt-4 text-2xl font-bold text-green-700">مرحباً بك في نظام عصائر عم حسني</h1>
                <p class="text-gray-500 mt-1">يرجى تسجيل الدخول للمتابعة</p>
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600 text-center">
                {{ status }}
            </div>

            <form @submit.prevent="submit" dir="rtl">
                <div>
                    <InputLabel for="email" value="البريد الإلكتروني" class="font-bold" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="example@email.com"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="كلمة المرور" class="font-bold" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center cursor-pointer select-none">
                        <Checkbox v-model:checked="form.remember" name="remember" />
                        <span class="ms-2 text-sm text-gray-700">تذكرني</span>
                    </label>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-2">
                    <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-green-700 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                        نسيت كلمة المرور؟
                    </Link>

                    <PrimaryButton class="w-full sm:w-auto bg-green-500 hover:bg-green-600 border-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        دخول
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
