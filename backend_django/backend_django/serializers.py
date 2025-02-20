from rest_framework_simplejwt.serializers import TokenObtainPairSerializer
from django.contrib.auth import get_user_model
from rest_framework import serializers

User = get_user_model()

class CustomTokenObtainPairSerializer(TokenObtainPairSerializer):
    @classmethod
    def get_token(cls, user):
        token = super().get_token(user)
        token['email'] = user.email  # Adiciona o e-mail no payload do token
        return token

    def validate(self, attrs):
        # Substituir username por email para autenticação
        email = attrs.get("username")  # Django usa 'username' por padrão, que será o email
        password = attrs.get("password")

        user = User.objects.filter(email=email).first()
        if user and user.check_password(password):
            attrs["username"] = user.username  # Define o username internamente para autenticação
        else:
            raise serializers.ValidationError("Credenciais inválidas.")

        return super().validate(attrs)