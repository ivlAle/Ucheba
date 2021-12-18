from django.urls import path
from .views import *


urlpatterns = [
    path('', index, name='index'),
    path('story_of_services/', story_of_services, name='story_of_services'),
    path('product_list/', product_list, name='product_list'),
    path('registration/', RegistrationFormView.as_view(), name='register'),
    path('login/', MainLoginView.as_view(), name='login'),
    path('logout/', MainLogoutView.as_view(), name='logout'),
    path('service/', ServiceCreateView, name='service'),
]
