from django.contrib import admin
from .models import *


class ServiceAdmin(admin.ModelAdmin):
    list_display = ('product', 'payment', 'user', 'delivery', 'date_at', 'description', 'status')


admin.site.register(Service, ServiceAdmin)

admin.site.register(AdvUser)
admin.site.register(Product)
admin.site.register(Payment)
admin.site.register(Delivery)
