from django.contrib.auth.models import User, AbstractUser
from django.db import models
from django.dispatch import Signal

user_registrated = Signal(providing_args=['instance'])


class AdvUser(AbstractUser):
    phone = models.CharField(max_length=50, verbose_name='Номер телефона', db_index=True)

    class Meta:
        verbose_name = 'Пользователь'
        verbose_name_plural = 'Пользовательи'

    def __str__(self):
        return self.username

    def get_current_user(request):
        user = request.user
        return user

    def delete(self, *args, **kwargs):
        for bb in self.additionalimage_set.all():
            bb.delete()
        super().delete(*args, **kwargs)

    class Meta:
        pass


class Product(models.Model):
    name = models.CharField(max_length=400, verbose_name='Название')
    price = models.FloatField(verbose_name='Цена')

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = 'Вид услуг'
        verbose_name_plural = 'Виды услуг'


class Payment(models.Model):
    name = models.CharField(max_length=400, verbose_name='Название')

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = 'Формат оплаты'
        verbose_name_plural = 'Форматы оплаты'


class Delivery(models.Model):
    name = models.CharField(max_length=400, verbose_name='Название')

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = 'Формат доставки'
        verbose_name_plural = 'Форматы доставки'


class Service(models.Model):
    STATUS_CHOISES = (
        ('Введён', 'Введён'),
        ('Отправлен', 'Отправлен'),
        ('Оплачен', 'Оплачен')
    )
    product = models.ForeignKey(Product, on_delete=models.CASCADE, related_name='products', verbose_name='Услуга')
    payment = models.ForeignKey(Payment, on_delete=models.CASCADE, related_name='payments',
                                verbose_name='Формат оплаты')
    user = models.ForeignKey(AdvUser, on_delete=models.CASCADE, verbose_name='Клиент')
    delivery = models.ForeignKey(Delivery, on_delete=models.CASCADE, related_name='deliveries',
                                 verbose_name='Формат доставки')
    date_at = models.DateTimeField(auto_now=True, verbose_name='Дата')
    description = models.TextField(verbose_name='Примечания')
    status = models.CharField(max_length=100, choices=STATUS_CHOISES, default='Введён')

    class Meta:
        verbose_name = 'Услуга'
        verbose_name_plural = 'Услуги'

    def get_product_price(self, Procuct):
        return Procuct._meta.price