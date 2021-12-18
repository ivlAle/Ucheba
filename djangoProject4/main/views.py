from django.contrib import messages
from django.contrib.auth.decorators import login_required
from django.contrib.auth.mixins import LoginRequiredMixin
from django.contrib.auth.views import LoginView, LogoutView
from django.shortcuts import render, redirect
from django.urls import reverse_lazy
from django.views.generic import CreateView
from .forms import *


def index(request):
    return render(request, 'index.html')


def story_of_services(request):
    name = None
    if request.method == 'POST':
        form = ProductForm(request.POST)
        if form.is_valid():
            name = form.cleaned_data['product']
    else:
        form = ProductForm()
    ysl1 = Service.objects.filter(product=name).count()
    objs = Service.objects.filter(product=name)
    context = {
        'ysl1': ysl1,
        'objs': objs,
        'form': form
    }
    return render(request, 'story_of_services.html', context)


def product_list(request):
    products = Service.objects.filter(status='Введён')

    context = {
        'products': products,
    }
    return render(request, 'product_list.html', context)


class RegistrationFormView(CreateView):
    model = AdvUser
    form_class = AdvUserCreationForm
    template_name = 'registration.html'
    success_url = reverse_lazy('index')

    def post(self, request, *args, **kwargs):
        form = AdvUserCreationForm(request.POST)
        if form.is_valid():
            user = form.save(commit=False)
            user.save()
            return redirect('index')


class MainLoginView(LoginView):
    template_name = 'login.html'
    success_url = reverse_lazy('index')

    def get_success_url(self):
        return self.success_url


class MainLogoutView(LoginRequiredMixin, LogoutView):
    template_name = 'logout.html'


def ServiceCreateView(request):
    user = AdvUser.objects.get(username=request.user.username)
    if request.method == 'POST':
        form = ServiceCreateForm(request.POST)
        if form.is_valid():
            post = form.save(commit=False)
            post.user = user
            post.save()
            messages.add_message(request, messages.SUCCESS, 'Объявление добавлено')
            return redirect('index')
    else:
        form = ServiceCreateForm(initial={'user': request.user.pk})
    context = {'form': form}
    return render(request, 'service.html', context)
