from rest_framework import serializers
from django.conf import settings
from .models import Art

class ArtSerializer(serializers.ModelSerializer):
    username = serializers.ReadOnlyField(source='user.username')
    image = serializers.SerializerMethodField()  # Retorna URL completa da imagem

    class Meta:
        model = Art
        fields = ['id', 'user', 'username', 'image', 'caption', 'created_at']

    def get_image(self, obj):
        request = self.context.get('request')
        if obj.image:
            return request.build_absolute_uri(obj.image.url)  # Gera URL completa
        return None
