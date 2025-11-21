# urls.py
from django.urls import path
from . import views
from .views import SendNotificationView


urlpatterns = [
    path("fcm/send/", SendNotificationView.as_view(), name="send-notification"),
]